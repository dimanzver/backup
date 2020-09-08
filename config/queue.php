<?php

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;
use yii\queue\LogBehavior;

return [
    'class' => Queue::class,
    'db' => 'db', // DB connection component or its config
    'tableName' => '{{%queue}}', // Table name
    'channel' => 'default', // Queue channel key
    'mutex' => MysqlMutex::class, // Mutex used to sync queries
    'as log' => LogBehavior::class,
];