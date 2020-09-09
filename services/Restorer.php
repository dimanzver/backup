<?php


namespace app\services;


use app\FileUploaders\FileUploaderContext;
use app\models\Backup;
use app\models\Settings;
use app\models\Site;

class Restorer
{

    /**
     * @var Backup
     */
    private $backup;

    /**
     * @var Site
     */
    private $site;

    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
        $this->site = $this->backup->site;
        $this->uploader = FileUploaderContext::getUploader(Settings::getValue('uploadMethod'), $this->backup);
        $this->logger = new BackupLogger(['prefix' => 'restore']);
    }

    public function start() {

    }

}