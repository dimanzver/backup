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
            'dir' => $site->title . '/' . date('Y-m-d H_i_s'),
            'pid' => getmypid(),
        ]);
        $this->backup->save();

        // После прибития процесса/ошибки - убираем pid и ставим статус ABORTED
        pcntl_async_signals(true);
        register_shutdown_function([$this, 'abort']);
        pcntl_signal(SIGTERM, [$this, 'abort']);
        pcntl_signal(SIGINT, [$this, 'abort']);

        $this->uploader = FileUploaderContext::getUploader(Settings::getValue('uploadMethod'), $this->backup);

        $this->logger = new BackupLogger(['prefix' => 'backup']);
        $this->backupStorageDir = self::ARCHIVES_DIR . '/' . $this->backup->dir;
        if (!is_dir($this->backupStorageDir)) {
            mkdir($this->backupStorageDir, 0777, true);
        }
    }

    public function start()
    {
        $this->backup->updateProgress('Начато резервное копирование');
        $filesBackupper = new FilesBackupper($this->backup, $this->uploader, $this->logger);
        $filesBackupper->start();

        $this->backup->updateProgress('Начато резервное копирование базы данных');
        $dbDumper = DbDumperContext::getDumper($this->site->db_driver, $this->backupStorageDir, $this->logger,
            [
                'dbName' => $this->site->db_name,
                'host' => $this->site->db_host,
                'user' => $this->site->db_user,
                'password' => $this->site->db_password,
            ]);
        $dbDumper->dump();

        $this->backup->updateProgress('Выгрузка дампа базы данных');
        $this->uploader->upload($dbDumper->file);
        unlink($dbDumper->file);
        $this->backup->updateProgress('Резервное копирование завершено');

        $this->logger->write('Finished db backup at ' . date('Y-m-d H:i:s'));
        $this->finish();
    }

    public function finish() {
        $this->backup->status = Backup::STATUSES['FINISHED'];
        $this->backup->pid = null;
        $this->backup->save();
    }

    public function abort() {
        if($this->backup->status !== Backup::STATUSES['PROCESSING'] && $this->backup->status !== null)
            return;

        $this->backup->status = Backup::STATUSES['ABORTED'];
        $this->backup->pid = null;
        $this->backup->save();
        exit;
    }
}