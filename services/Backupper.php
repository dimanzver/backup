<?php


namespace app\services;


use app\DBDumpers\DbDumperContext;
use app\FileUploaders\FileUploader;
use app\FileUploaders\FileUploaderContext;
use app\models\Backup;
use app\models\Settings;
use app\models\Site;

class Backupper
{
    /**
     * @var FileUploader
     */
    protected $uploader;

    const ARCHIVES_DIR = ROOT_PATH.'/storage/archives';

    /**
     * @var Site
     */
    protected $site;

    /**
     * @var Backup
     */
    protected $backup;


    /**
     * @var BackupLogger
     */
    protected $logger;

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->backup = new Backup([
            'site_id' => $this->site->id,
            'dir' => $site->title . '/' . date('Y-m-d H_i_s')
        ]);
        $this->backup->save();
        $this->uploader = FileUploaderContext::getUploader(Settings::getValue('uploadMethod'), $this->backup);

        $this->logger = new BackupLogger(['prefix' => 'files']);
        $this->backupStorageDir = self::ARCHIVES_DIR . '/' . $this->backup->dir;
        if (!is_dir($this->backupStorageDir)) {
            mkdir($this->backupStorageDir, 0777, true);
        }
    }

    public function start()
    {
        $filesBackupper = new FilesBackupper([
            'dir' => $this->site->dir,
            'archiveSize' => $this->site->part_size,
        ], $this->uploader, $this->logger, $this->backupStorageDir);
        $filesBackupper->start();

        $dbDumper = DbDumperContext::getDumper('mysql', $this->backupStorageDir, $this->logger, $this->uploader,
            [
                'dbName' => $this->site->db_name,
                'host' => $this->site->db_host,
                'user' => $this->site->db_user,
                'password' => $this->site->db_password,
            ]);
        $dbDumper->dump();
    }

}