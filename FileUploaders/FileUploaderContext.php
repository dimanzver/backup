<?php


namespace app\FileUploaders;

use app\Exceptions\InvalidConfigurationException;
use app\models\Backup;

class FileUploaderContext
{

    /**
     * @param  string  $name
     * @return FileUploader
     */
    public static function getUploader(string $name, Backup $backup){
        switch ($name){
            case 'google-drive':
                return new GoogleDriveUploader($backup);

            default:
                throw new InvalidConfigurationException('Неверный метод загрузки файла');
        }
    }

}