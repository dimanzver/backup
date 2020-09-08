<?php


namespace app\DBDumpers;

use app\services\BackupLogger;
use Exception;

class MysqlDumper implements DbDumperInterface
{
    protected $dbName;
    protected $host;
    protected $user;
    protected $password;
    protected $backupStorageDir;

    /**
     * @var BackupLogger
     */
    protected $logger;

    public $file;


    public function __construct($config, $backupStorageDir, $logger)
    {
        $this->dbName = $config['dbName'];
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->password = $config['password'];
        $this->backupStorageDir = $backupStorageDir;
        $this->logger = $logger;
    }

    public function dump()
    {
        $this->logger->write('Started db backup at ' . date('Y-m-d H:i:s'));
        $this->file = $this->backupStorageDir . '/' . $this->dbName . '.sql.gz';
        $command = 'mysqldump -u' . $this->user . ' -h' . $this->host . ' -p' . $this->password . ' ' . $this->dbName . ' | gzip > "' . $this->file . '"';
        exec($command, $result, $status);

        if($status) {
            $this->logger->write('Error: ' . json_encode($result));
            throw new Exception('Не удалось сделать бэкап базы данных');
        }
    }

    public function restore()
    {
        // TODO: Implement restore() method.
    }
}