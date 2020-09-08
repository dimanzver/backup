<?php


namespace app\jobs;


use app\models\Site;
use app\services\Backupper;
use yii\queue\JobInterface;

class BackupJob extends BaseJob implements JobInterface
{
    public $siteId;

    /**
     * @param  \yii\queue\Queue  $queue
     * @return mixed|void
     */
    public function execute($queue)
    {
        $site = Site::findOne($this->siteId);
        $backupper = new Backupper($site);
        $backupper->start();
    }
}