<?php


namespace app\Services;


use app\FileUploaders\FileUploader;
use app\FileUploaders\NullFileUploader;
use ZipArchive;

class FilesBackupper
{

    protected $dir;
    protected $backupStorageDir;

    /**
     * @var int Size of part archive (MB)
     */
    protected $archiveSize = 50;

    /**
     * @var BackupLogger
     */
    protected $logger;

    /**
     * @var FileUploader
     */
    protected $uploader;



    protected $files;
    protected $filesCount;
    protected $processedFiles = 0;
    protected $filesize = 0;

    /**
     * @var ZipArchive
     */
    protected $archive;



    public function __construct(array $config, FileUploader $uploader, BackupLogger $logger, string $backupStorageDir)
    {
        $this->dir = $config['dir'];
        if(isset($config['archiveSize']))
            $this->archiveSize = $config['archiveSize'];
        $this->uploader = $uploader;
        $this->logger = $logger;
        $this->backupStorageDir = $backupStorageDir;
    }


    public function start(){
        $this->logger->write('Started at ' . date('Y-m-d H:i:s'));
        $this->files = getDirContents($this->dir);
        $this->filesCount = count($this->files);
        $this->logger->write('Found files:' . $this->filesCount);

        // While has files, process
        // Files separated into some archives with limited size
        while ($this->processedFiles < $this->filesCount){
            $this->backupFilesStep();
        }

        $this->logger->write('Finished files backup at ' . date('Y-m-d H:i:s'));
    }


    /**
     * Created archive with some of files
     * Archive size is limited
     */
    protected function backupFilesStep(){
        $this->archive = new ZipArchive();
        $filename = $this->backupStorageDir . '/' . date('Y-m-d__H:i:s') . uniqid() . '.zip';
        $this->archive->open($filename, ZipArchive::CREATE);
        $this->filesize = 0;
        $i = 0;

        // add new files on archive before size limit or end
        do{
            $file = $this->files[$this->processedFiles];
            $this->processFile($file);
            //TODO: fix filesize calculating
            $this->filesize += $this->archive->statIndex($i)['size'];
            $this->processedFiles++;
            $i++;
        }while(
            $this->filesize < $this->archiveSize * 1024 * 1024 &&
            $this->processedFiles < $this->filesCount
        );

        $this->logger->write('Created archive part ' . $filename);
        $this->archive->close();
        $this->uploader->upload($filename);
        if(!($this->uploader instanceof NullFileUploader))
            unlink($filename);
    }

    /**
     * Process one file
     *
     * @param string $filename
     */
    protected function processFile($filename){
        $archiveFilename = trim($this->getArchiveFilename($filename), '/');
        $this->archive->addFile(realpath($filename), $archiveFilename);
        $this->logger->write('Write file ' . $archiveFilename);
    }

    protected function getArchiveFilename($filename){
        return str_replace($this->dir, '', $filename);
    }

}