<?php

use yii\db\Migration;

/**
 * Class m200908_085440_add_backup_dir
 */
class m200908_085440_add_backup_dir extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('backups', 'dir', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_085440_add_backup_dir cannot be reverted.\n";

        return false;
    }
}
