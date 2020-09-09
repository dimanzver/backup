<?php


namespace app\jobs;


use app\models\Backup;
use app\services\Restorer;
use yii\queue\JobInterface;

class RestoreJob extends BaseJob implements JobInterface
{
    public $backupId;

    public function execute($queue)
    {
        $backup = Backup::findOne($this->backupId);
        $restorer = new Restorer($backup);
        $restorer->start();
    }
}