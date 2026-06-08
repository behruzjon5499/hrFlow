<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_home}}`.
 */
class m251123_073154_create_evalue_home_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_home}}', [
            'id' => $this->primaryKey(),
            'client_type' => $this->integer(),
            'evalue_goal_id' => $this->integer(),
            'full_name' => $this->string(),
            'client_phone' => $this->string(),
            'bank_phone' => $this->string(),
            'passport' => $this->string(),
            'client_uid' => $this->string(),
            'cadastre_number' => $this->string(),
            'property_type' => $this->integer(),
            'housing_type' => $this->integer(),
            'description' => $this->text(),
            'region_id' => $this->integer(),
            'district_id' => $this->integer(),
            'address' => $this->text(),
            'longitude' => $this->string(),
            'latitude' => $this->string(),
            'room_count' => $this->integer(),
            'total_area' => $this->double(),
            'living_area' => $this->double(),
            'building_material_id' => $this->integer(),
            'repair_state_id' => $this->integer(),
            'home_plan_id' => $this->integer(),
            'floor' => $this->integer(),
            'home_floor' => $this->integer(),
            'bathroom_type' => $this->integer(),
            'building_year' => $this->integer(),
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
        $this->createIndex('idx-evalue_home-client_type', 'evalue_home', 'client_type');
        $this->createIndex('idx-evalue_home-client_uid', 'evalue_home', 'client_uid');
        $this->createIndex('idx-evalue_home-region_id', 'evalue_home', 'region_id');
        $this->createIndex('idx-evalue_home-district_id', 'evalue_home', 'district_id');
        $this->createIndex('idx-evalue_home-created_at', 'evalue_home', 'created_at');
        $this->createIndex('idx-evalue_home-status', 'evalue_home', 'status');
        $this->createIndex('idx-evalue_home-is_deleted', 'evalue_home', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_home}}');
    }
}
