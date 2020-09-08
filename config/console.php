<?php



$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'backup-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue', 'ideHelper',],
    'controllerNamespace' => 'app\commands',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [

    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
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

        'queue' => require __DIR__ . '/queue.php',

        'redis' => [
            'class' => \yii\redis\Connection::class,
        ],

        'ideHelper' => [
            'class' => 'Mis\IdeHelper\IdeHelper',
        ],
    ],

    'controllerMap' => [
//        'fixture' => [ // Fixture generation command line.
//            'class' => 'yii\faker\FixtureController',
//        ],

        'tinker' => [ // Tinker command line.
            'class' => \Yii2Tinker\TinkerController::class,
        ],

        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
            ],
        ],

    ],

    'params' => [

    ],
];

return $config;