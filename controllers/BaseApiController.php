<?php


namespace app\controllers;


use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class BaseApiController extends Controller
{

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

}