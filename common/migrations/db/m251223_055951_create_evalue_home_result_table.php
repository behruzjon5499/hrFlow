<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_home_result}}`.
 */
class m251223_055951_create_evalue_home_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_home_result}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'evalue_generate_id' => $this->integer(),
            'adjusted_sum' => $this->decimal(20,2),
            'area_percent' => $this->integer(),
            'area_sum' => $this->decimal(20,2),
            'state' => $this->string(),
            'state_sum' => $this->decimal(20,2),
            'floor' => $this->string(),
            'floor_sum' => $this->decimal(20,2),
            'total_adjustment' => $this->double(),
            'intermediate_indicator' => $this->double(),
            'specific_gravity_percent' => $this->double(),
            'result_sum' => $this->double(),
            'order' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_home_result}}');
    }
}
