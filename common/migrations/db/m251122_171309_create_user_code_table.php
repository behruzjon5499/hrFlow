<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_code}}`.
 */
class m251122_171309_create_user_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_code}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'user_id' => $this->integer(),
            'expired_at' => $this->integer(),
            'order' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean(),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('idx-user_code-code', 'user_code', 'code');
        $this->createIndex('idx-user_code-expired_at', 'user_code', 'expired_at');
        $this->createIndex('idx-user_code-user_id', 'user_code', 'user_id');
        $this->createIndex('idx-user_code-status', 'user_code', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_code}}');
    }
}
