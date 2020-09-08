<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sites}}`.
 */
class m200825_174505_create_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sites}}', [
            'id' => $this->primaryKey()->unsigned(),
            'title' => $this->string()->notNull(),
            'dir' => $this->string()->notNull(),
            'db_driver' => $this->string()->notNull(),
            'db_host' => $this->string()->notNull(),
            'db_name' => $this->string()->notNull(),
            'db_user' => $this->string()->notNull(),
            'db_password' => $this->string()->notNull(),
            'store_count' => $this->integer()->unsigned(),
            'part_size' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sites}}');
    }
}
