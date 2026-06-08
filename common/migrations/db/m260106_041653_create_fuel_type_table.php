<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fuel_type}}`.
 */
class m260106_041653_create_fuel_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fuel_type}}', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'key' => $this->string(),
            'extra_ids' => $this->json(),
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
        $this->createIndex('idx-fuel_type-key', 'fuel_type', 'key');
        $this->createIndex('idx-fuel_type-is_deleted', 'fuel_type', 'is_deleted');
        $this->createIndex('idx-fuel_type-order', 'fuel_type', 'order');
        $this->createIndex('idx-fuel_type-status', 'fuel_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fuel_type}}');
    }
}
