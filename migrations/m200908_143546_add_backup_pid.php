<?php

use yii\db\Migration;

/**
 * Class m200908_143546_add_backup_pid
 */
class m200908_143546_add_backup_pid extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('backups', 'pid', $this->integer()->unsigned()->null());;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_143546_add_backup_pid cannot be reverted.\n";

        return false;
    }
}
