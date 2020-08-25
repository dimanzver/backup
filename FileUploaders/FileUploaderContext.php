<?php


namespace app\FileUploaders;


class FileUploaderContext
{

    /**
     * @param  string  $name
     * @return FileUploaderInterface
     */
    public static function getUploader(string $name){
        switch ($name){


            default:
                return new NullFileUploader();
        }
    }

}