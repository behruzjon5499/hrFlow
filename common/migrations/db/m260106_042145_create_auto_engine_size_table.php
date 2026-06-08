<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto_engine_size}}`.
 */
class m260106_042145_create_auto_engine_size_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auto_engine_size}}', [
            'id' => $this->primaryKey(),
            'evalue_auto_id' => $this->integer(),
            'engine_size_id' => $this->integer(),
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
        $this->createIndex('idx-auto_engine_size-evalue_auto_id', 'auto_engine_size', 'evalue_auto_id');
        $this->createIndex('idx-auto_engine_size-engine_size_id', 'auto_engine_size', 'engine_size_id');
        $this->createIndex('idx-auto_engine_size-is_deleted', 'auto_engine_size', 'is_deleted');
        $this->createIndex('idx-auto_engine_size-status', 'auto_engine_size', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auto_engine_size}}');
    }
}
