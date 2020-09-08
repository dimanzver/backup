<?php


namespace app\controllers;


use app\jobs\BackupJob;
use app\jobs\StopBackupJob;
use app\models\Backup;
use Yii;

class BackupsController extends BaseApiController
{
    public function actionIndex() {
        return Backup::find()
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
    }

    public function actionStart($id) {
        return Yii::$app->queue->ttr(86400)->push(new BackupJob([
            'siteId' => $id,
        ]));
    }

    public function actionStop($id) {
        Yii::$app->queue->push(new StopBackupJob(compact('id')));
    }
}