<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
class m241217_153559_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%token}}', [
            'id' => $this->primaryKey(),
            'token' => $this->string(),
            'user_id' => $this->integer(),
            'type' => $this->integer(),
            'expired_at' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token}}');
    }
}
