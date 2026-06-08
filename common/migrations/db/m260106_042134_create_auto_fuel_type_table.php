<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto_fuel_type}}`.
 */
class m260106_042134_create_auto_fuel_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auto_fuel_type}}', [
            'id' => $this->primaryKey(),
            'evalue_auto_id' => $this->integer(),
            'fuel_type_id' => $this->integer(),
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
        $this->createIndex('idx-auto_fuel_type-evalue_auto_id', 'auto_fuel_type', 'evalue_auto_id');
        $this->createIndex('idx-auto_fuel_type-fuel_type_id', 'auto_fuel_type', 'fuel_type_id');
        $this->createIndex('idx-auto_fuel_type-is_deleted', 'auto_fuel_type', 'is_deleted');
        $this->createIndex('idx-auto_fuel_type-status', 'auto_fuel_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auto_fuel_type}}');
    }
}
