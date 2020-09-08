<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%backups}}`.
 */
class m200907_195805_create_backups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%backups}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'site_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-backups-site_id',
            'backups',
            'site_id',
            'sites',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%backups}}');
    }
}
