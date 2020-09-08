<?php


namespace app\controllers;


use app\FileUploaders\GoogleDriveUploader;
use Exception;
use Yii;

class GoogleDriveController extends BaseApiController
{

    public function actionCheckAuth(){;
        return GoogleDriveUploader::checkAuthOrGetUrl();
    }

    public function actionAuth(){
        $authCode = Yii::$app->request->post('authCode');
        try {
            GoogleDriveUploader::auth($authCode);
        } catch (Exception $e) {
            Yii::$app->response->setStatusCode(401);
        }
    }

}