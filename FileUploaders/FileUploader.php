<?php


namespace app\FileUploaders;


use app\models\Backup;
use app\services\TmpFile;

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

    /**
     * Выгрузка файла в облако
     *
     * @param $file
     */
    abstract public function upload($file);

    /**
     * Загрузка файла из облака, должен возвращать локальный путь к файлу
     *
     * @param $remotePath
     * @return TmpFile
     */
    abstract public function download($remotePath) : ?TmpFile;

}