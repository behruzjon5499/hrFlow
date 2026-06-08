<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_view}}`.
 */
class m251130_150137_create_evalue_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_view}}', [
            'id' => $this->primaryKey(),
            'evalue_id' => $this->integer(),
            'type' => $this->string(),
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
        $this->createIndex('idx-evalue_view-evalue_id', 'evalue_view', 'evalue_id');
        $this->createIndex('idx-evalue_view-type', 'evalue_view', 'type');
        $this->createIndex('idx-evalue_view-created_at', 'evalue_view', 'created_at');
        $this->createIndex('idx-evalue_view-status', 'evalue_view', 'status');
        $this->createIndex('idx-evalue_view-is_deleted', 'evalue_view', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_view}}');
    }
}
