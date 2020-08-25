<?php


namespace app\commands;


use app\services\Backupper;
use yii\console\Controller;

class BackupController extends Controller
{

    public function actionStart(){
        $filesBackupper = new Backupper([
            'dir' => '/var/www/old.soho',
            'uploader' => 'null',
        ]);
        $filesBackupper->start();
    }

}