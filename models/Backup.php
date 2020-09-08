<?php


namespace app\models;


/**
 * Class Backup
 * @package app\models
 *
 * @property int $id
 * @property string $dir
 *
 * @property Site $site
 */

class Backup extends BaseModel
{

    public static function tableName()
    {
        return 'backups';
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'site';
        return $fields;
    }

    /**
     * Gets query for [[Site]].
     *
     * @return \yii\db\ActiveQuery|Site
     */
    public function getSite()
    {
        return $this->hasOne(Site::class, ['id' => 'site_id']);
    }

}