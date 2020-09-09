<?php


namespace app\Services;


use app\FileUploaders\FileUploader;
use app\models\Backup;
use ZipArchive;

class FilesBackupper
{

    protected $dir;

    /**
     * @var int Size of part archive (MB)
     */
    protected $archiveSize = 25;

    /**
     * @var BackupLogger
     */
    protected $logger;

    /**
     * @var FileUploader
     */
    protected $uploader;

    /**
     * @var Backup
     */
    protected $backup;



    protected $files;
    protected $filesCount;
    protected $processedFiles = 0;
    protected $filesize = 0;
    protected $filesTree = [
        'dirs' => [],
        'files' => [],
    ];

    /**
     * @var ZipArchive
     */
    protected $archive;



    public function __construct(Backup $backup, FileUploader $uploader, BackupLogger $logger)
    {
        $this->backup = $backup;
        $this->dir = $backup->site->dir;
        if(!empty($backup->site->part_size))
            $this->archiveSize = $backup->site->part_size;
        $this->uploader = $uploader;
        $this->logger = $logger;
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
        file_put_contents('/tmp/qaz' . time(), json_encode($this->filesTree));
        $this->logger->write('Finished files backup at ' . date('Y-m-d H:i:s'));
    }


    /**
     * Created archive with some of files
     * Archive size is limited
     */
    protected function backupFilesStep(){
        $this->backup->updateProgress('Резервное копирование и выгрузка файлов (готово ' . $this->processedFiles . ' из ' . $this->filesCount . ')');

        $this->archive = new ZipArchive();
        $filename = $this->backup->getDir() . '/' . date('Y-m-d__H:i:s') . uniqid() . '.zip';
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
        unlink($filename);

        // TODO: how throttle else?
        sleep(3);
    }

    /**
     * Process one file
     *
     * @param string $filename
     */
    protected function processFile($filename){
        $fromBasePath = str_replace($this->backup->site->dir, '', $filename);
        $pathInfo = pathinfo($fromBasePath);
        $path = array_values(array_filter(explode('/', $pathInfo['dirname'])));
        $arr = &$this->filesTree;
        $i = 0;

        while ($i < count($path)) {
            if(!isset($arr['dirs'][$path[$i]]))
                $arr['dirs'][$path[$i]] = [
                    'dirs' => [],
                    'files' => [],
                ];
            $arr = &$arr['dirs'][$path[$i]];
            $i++;
        }
        $arr['files'][] = [
            'name' => $pathInfo['basename'],
            'archive' => pathinfo($this->archive->filename, PATHINFO_BASENAME),
        ];

        $archiveFilename = trim($this->getArchiveFilename($filename), '/');
        $this->archive->addFile(realpath($filename), $archiveFilename);
        $this->logger->write('Write file ' . $archiveFilename);
    }

    protected function getArchiveFilename($filename){
        return str_replace($this->dir, '', $filename);
    }
}