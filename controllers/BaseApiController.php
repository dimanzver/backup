<?php


namespace app\controllers;


use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class BaseApiController extends Controller
{

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBasicAuth::class;
        return $behaviors;
    }

}