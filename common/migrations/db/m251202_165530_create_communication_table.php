<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%communication}}`.
 */
class m251202_165530_create_communication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%communication}}', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'key' => $this->string(),
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
        $this->createIndex('idx-communication-key', 'communication', 'key');
        $this->createIndex('idx-communication-is_deleted', 'communication', 'is_deleted');
        $this->createIndex('idx-communication-order', 'communication', 'order');
        $this->createIndex('idx-communication-status', 'communication', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%communication}}');
    }
}
