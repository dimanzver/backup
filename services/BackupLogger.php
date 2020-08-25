<?php


namespace app\services;


class BackupLogger
{

    const LOGS_DIR = ROOT_PATH . '/storage/logs';
    protected $fp;
    protected $prefix = '';

    public function __construct(array $config = [])
    {
        if(isset($config['prefix'])){
            $this->prefix = $config['prefix'];
        }
        $filename = self::LOGS_DIR . '/' . time() . '_' . $this->prefix . '.log';
        if(!is_dir(self::LOGS_DIR))
            mkdir(self::LOGS_DIR, 0777, true);
        $this->fp = fopen($filename, 'a');
    }

    public function write($message){
        fwrite($this->fp, $message . "\r\n");
    }


    public function __destruct()
    {
        fclose($this->fp);
    }
}