<?php


namespace app\controllers;


use app\models\Site;

class SitesController extends BaseApiController
{

    public function actionIndex(){
        return Site::find()->all();
    }

}