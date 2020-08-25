<?php


namespace app\services;


use app\DBDumpers\DbDumperContext;
use app\FileUploaders\FileUploaderContext;
use app\FileUploaders\FileUploaderInterface;

class Backupper
{
    /**
     * @var FileUploaderInterface
     */
    protected $uploader;

    const ARCHIVES_DIR = ROOT_PATH.'/storage/archives';

    protected $config;


    /**
     * @var BackupLogger
     */
    protected $logger;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->uploader = FileUploaderContext::getUploader($config['uploader']);

        $this->logger = new BackupLogger(['prefix' => 'files']);
        $this->backupStorageDir = self::ARCHIVES_DIR.'/'.date('Y-m-d H_i_s');
        if (!is_dir($this->backupStorageDir)) {
            mkdir($this->backupStorageDir, 0777, true);
        }
    }

    public function start()
    {
        $filesBackupper = new FilesBackupper($this->config, $this->uploader, $this->logger, $this->backupStorageDir);
        $filesBackupper->start();

        $dbDumper = DbDumperContext::getDumper('mysql', $this->backupStorageDir, $this->logger, $this->uploader,
            [
                'dbName' => env('DB_NAME'),
                'host' => env('DB_HOST'),
                'user' => env('DB_USER'),
                'password' => env('DB_PASSWORD'),
            ]);
        $dbDumper->dump();
    }

}