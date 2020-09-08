<?php


namespace app\FileUploaders;


use app\models\Backup;

abstract class FileUploader
{
    /**
     * @var Backup
     */
    protected $backup;

    public function __construct(Backup $backup)
    {
        $this->backup = $backup;
    }

    abstract public function upload($file);

}