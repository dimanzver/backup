<?php

use yii\db\Migration;

/**
 * Class m200908_165314_add_backup_status_and_progress_text
 */
class m200908_165314_add_backup_status_and_progress_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('backups', 'status', $this->integer()->notNull()->defaultValue(0));
        $this->addColumn('backups', 'progress_text', $this->string()->defaultValue(''));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200908_165314_add_backup_status_and_progress_text cannot be reverted.\n";

        return false;
    }
}
