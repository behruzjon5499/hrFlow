<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_home_floor}}`.
 */
class m260330_155604_create_evalue_home_floor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_home_floor}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'floor' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean(),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_home_floor}}');
    }
}
