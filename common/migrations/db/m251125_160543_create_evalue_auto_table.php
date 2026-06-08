<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_auto}}`.
 */
class m251125_160543_create_evalue_auto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_auto}}', [
            'id' => $this->primaryKey(),
            'client_type' => $this->integer(),
            'evalue_goal_id' => $this->integer(),
            'full_name' => $this->string(),
            'client_phone' => $this->string(),
            'bank_phone' => $this->string(),
            'passport' => $this->string(),
            'client_uid' => $this->string(),
            'auto_type_id' => $this->integer(),
            'auto_marka_id' => $this->integer(),
            'auto_model_id' => $this->integer(),
            'description' => $this->text(),
            'price' => $this->decimal(20,2),
            'currency' => $this->string(),
            'body_type_id' => $this->integer(),
            'year' => $this->integer(),
            'run_km' => $this->double(),
            'gearbox_id' => $this->integer(),
            'engine_size' => $this->double(),
            'fuel_type' => $this->integer(),
            'repair_state_id' => $this->integer(),
            'number_owner' => $this->integer(),
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
        $this->createIndex('idx-evalue_auto-client_type', 'evalue_auto', 'client_type');
        $this->createIndex('idx-evalue_auto-client_uid', 'evalue_auto', 'client_uid');
        $this->createIndex('idx-evalue_auto-created_at', 'evalue_auto', 'created_at');
        $this->createIndex('idx-evalue_auto-price', 'evalue_auto', 'price');
        $this->createIndex('idx-evalue_auto-auto_model_id', 'evalue_auto', 'auto_model_id');
        $this->createIndex('idx-evalue_auto-auto_marka_id', 'evalue_auto', 'auto_marka_id');
        $this->createIndex('idx-evalue_auto-auto_type_id', 'evalue_auto', 'auto_type_id');
        $this->createIndex('idx-evalue_auto-year', 'evalue_auto', 'year');
        $this->createIndex('idx-evalue_auto-status', 'evalue_auto', 'status');
        $this->createIndex('idx-evalue_auto-is_deleted', 'evalue_auto', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_auto}}');
    }
}
