<?php


namespace app\models;


use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{

    public function updateFields($data) {
        $this->load($data, '');
        $this->save();
    }

}