<?php


namespace app\jobs;


use app\models\Backup;
use yii\queue\JobInterface;

class StopBackupJob extends BaseJob implements JobInterface
{
    public $id;

    public function execute($queue)
    {
        $backup = Backup::findOne($this->id);
        if(!empty($backup->pid))
            posix_kill($backup->pid, 15);
    }
}