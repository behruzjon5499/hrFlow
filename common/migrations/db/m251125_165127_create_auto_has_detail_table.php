<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto_has_detail}}`.
 */
class m251125_165127_create_auto_has_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auto_has_detail}}', [
            'id' => $this->primaryKey(),
            'evalue_auto_id' => $this->integer(),
            'has_detail_id' => $this->integer(),
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
        $this->createIndex('idx-auto_has_detail-evalue_auto_id', 'auto_has_detail', 'evalue_auto_id');
        $this->createIndex('idx-auto_has_detail-has_detail_id', 'auto_has_detail', 'has_detail_id');
        $this->createIndex('idx-auto_has_detail-is_deleted', 'auto_has_detail', 'is_deleted');
        $this->createIndex('idx-auto_has_detail-order', 'auto_has_detail', 'order');
        $this->createIndex('idx-auto_has_detail-status', 'auto_has_detail', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auto_has_detail}}');
    }
}
