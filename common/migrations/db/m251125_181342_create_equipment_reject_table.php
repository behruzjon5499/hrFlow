<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_reject}}`.
 */
class m251125_181342_create_equipment_reject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_reject}}', [
            'id' => $this->primaryKey(),
            'evalue_equipment_id' => $this->integer(),
            'reject_type' => $this->integer(),
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
        $this->createIndex('idx-equipment_reject-evalue_equipment_id', 'equipment_reject', 'evalue_equipment_id');
        $this->createIndex('idx-equipment_reject-reject_type', 'equipment_reject', 'reject_type');
        $this->createIndex('idx-equipment_reject-is_deleted', 'equipment_reject', 'is_deleted');
        $this->createIndex('idx-equipment_reject-status', 'equipment_reject', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_reject}}');
    }
}
