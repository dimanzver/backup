<?php


namespace app\DBDumpers;


use app\Exceptions\InvalidConfigurationException;

class DbDumperContext
{

    public static function getDumper(string $name, $backupStorageDir, $logger, array $config = []){
        switch ($name){

            case 'mysql': {
                return new MysqlDumper($config, $backupStorageDir, $logger);
            }

            default: throw new InvalidConfigurationException('Unable to resolve database dumper: ' . $name);
        }
    }

}