<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_tokens}}`.
 */
class m200825_112843_create_auth_tokens_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_tokens}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'user_id' => $this->integer()->unsigned(),
            'token' => $this->string(),
            'expires' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-auth_tokens-user_id',
            'auth_tokens',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth_tokens}}');
    }
}
