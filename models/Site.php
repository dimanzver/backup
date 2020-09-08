<?php


namespace app\models;


/**
 * Class Site
 * @package app\models
 *
 * @property string $title
 * @property string $dir
 * @property string $db_driver
 * @property string $db_host
 * @property string $db_name
 * @property string $db_user
 * @property string $db_password
 * @property int $store_count
 * @property int $part_size
 */

class Site extends BaseModel
{
    public static function tableName()
    {
        return 'sites';
    }



}