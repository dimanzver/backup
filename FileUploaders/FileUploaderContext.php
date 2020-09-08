<?php


namespace app\FileUploaders;


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
                return new NullFileUploader($backup);
        }
    }

}