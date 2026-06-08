<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_equipment}}`.
 */
class m251125_175437_create_evalue_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_equipment}}', [
            'id' => $this->primaryKey(),
            'client_type' => $this->integer(),
            'evalue_goal_id' => $this->integer(),
            'full_name' => $this->string(),
            'client_phone' => $this->string(),
            'bank_phone' => $this->string(),
            'passport' => $this->string(),
            'client_uid' => $this->string(),
            'equipment_type_id' => $this->integer(),
            'description' => $this->text(),
            'reject_reason' => $this->text(),
            'rejected_user_id' => $this->integer(),
            'rejected_at' => $this->integer(),
            'price' => $this->decimal(20,2),
            'currency' => $this->string(),
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
        $this->createIndex('idx-evalue_equipment-client_type', 'evalue_equipment', 'client_type');
        $this->createIndex('idx-evalue_equipment-client_uid', 'evalue_equipment', 'client_uid');
        $this->createIndex('idx-evalue_equipment-created_at', 'evalue_equipment', 'created_at');
        $this->createIndex('idx-evalue_equipment-price', 'evalue_equipment', 'price');
        $this->createIndex('idx-evalue_equipment-currency', 'evalue_equipment', 'currency');
        $this->createIndex('idx-evalue_equipment-equipment_type_id', 'evalue_equipment', 'equipment_type_id');
        $this->createIndex('idx-evalue_equipment-status', 'evalue_equipment', 'status');
        $this->createIndex('idx-evalue_equipment-is_deleted', 'evalue_equipment', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_equipment}}');
    }
}
