<?php


namespace app\controllers;


use app\jobs\BackupJob;
use Yii;

class BackupController extends BaseApiController
{

    public function actionStart($id) {
        return Yii::$app->queue->ttr(86400)->push(new BackupJob([
            'siteId' => $id,
        ]));
    }

}