<?php


namespace app\controllers;


use app\models\Settings;
use Yii;

class SettingsController extends BaseApiController
{

    public function actionIndex() {
        return Settings::getAll();
    }

    public function actionSave() {
        $settings = Yii::$app->request->post('settings');
        foreach ($settings as $property => $value) {
            Settings::setValue($property, $value);
        }
        return Settings::getAll();
    }

}