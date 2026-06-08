<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_auto_result}}`.
 */
class m251223_063607_create_evalue_auto_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_auto_result}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'evalue_generate_id' => $this->integer(),
            'adjusted_sum' => $this->decimal(20,2),
            'year_percent' => $this->integer(),
            'year_sum' => $this->decimal(20,2),
            'km' => $this->string(),
            'omega' => $this->string(),
            'age_and_mileage' => $this->double(),
            'difference' => $this->double(),
            'difference_round' => $this->double(),
            'km_sum' => $this->decimal(20,2),
            'state_percent' => $this->string(),
            'state_sum' => $this->decimal(20,2),
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
        $this->dropTable('{{%evalue_auto_result}}');
    }
}
