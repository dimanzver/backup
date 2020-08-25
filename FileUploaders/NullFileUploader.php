<?php


namespace app\FileUploaders;


class NullFileUploader implements FileUploaderInterface
{

    public function upload($file)
    {

    }
}