<?php


namespace app\models;

use stdClass;

/**
 * Class Settings
 * @package app\models
 *
 * @property string $name
 * @property string $value
 */

class Settings extends BaseModel
{
    protected static $settings = [];
    protected static $defaults = [
        'uploadMethod' => 'google-drive',
        'baseRemote' => 'backups',
    ];

    public static function tableName()
    {
        return 'settings';
    }

    public static function primaryKey()
    {
        return ['name'];
    }

    /**
     * Get value of setting from cache or DB or default
     *
     * @param string $property
     * @return string|null
     */
    public static function getValue($property) {
        if(!isset(self::$settings[$property])){
            $setting = self::findOne($property);
        } else {
            $setting = self::$settings[$property];
        }
        return !empty($setting) ? $setting->value : self::$defaults[$property];
    }

    /**
     * Save value on DB, update cache
     *
     * @param string $property
     * @param string $value
     */
    public static function setValue($property, $value) {
        $setting = self::findOne($property);
        if(!$setting) {
            $setting = new self(['name' => $property]);
        }
        $setting->value = $value;
        $setting->save();
        self::$settings[$property] = $setting;
    }

    /**
     * Get object of all settings (key => value)
     *
     * @return stdClass
     */
    public static function getAll() {
        $rows = self::find()->all();
        $result = new stdClass();
        foreach ($rows as $row) {
            self::$settings[$row->name] = $row;
            $result->{$row->name} = $row->value;
        }

        // Merge defaults
        foreach (self::$defaults as $prop => $value) {
            if(!isset($result->$prop)) {
                $result->$prop = $value;
            }
        }

        return $result;
    }
}