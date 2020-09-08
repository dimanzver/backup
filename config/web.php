<?php

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;
use yii\queue\LogBehavior;

$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'backup-app',
    'bootstrap' => ['log', 'queue',],
    'timeZone' => 'Europe/Moscow',
    // the basePath of the application will be the `micro-app` directory
    'basePath' => dirname(__DIR__),
    // this is where the application will find all controllers
    'controllerNamespace' => 'app\controllers',
    // set an alias to enable autoloading of classes from the 'micro' namespace
    'aliases' => [
        '@app' => dirname(__DIR__),
    ],

    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'knJG4GYJGbJUL4QsHruhHFN17_JmDXSv',
            'enableCsrfValidation' => false,
            'baseUrl' => '/',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ],
        ],

        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                'api/<controller>/<action>' => '<controller>/<action>',
                'api/<controller>' => '<controller>/index',
            ],
        ],

        'queue' => [
            'class' => Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => MysqlMutex::class, // Mutex used to sync queries
            'as log' => LogBehavior::class,
        ],
    ],

    'params' => [

    ],
];

return $config;