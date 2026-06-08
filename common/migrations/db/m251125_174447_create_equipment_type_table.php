<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_type}}`.
 */
class m251125_174447_create_equipment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_type}}', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'key' => $this->string(),
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
        $this->createIndex('idx-equipment_type-key', 'equipment_type', 'key');
        $this->createIndex('idx-equipment_type-is_deleted', 'equipment_type', 'is_deleted');
        $this->createIndex('idx-equipment_type-order', 'equipment_type', 'order');
        $this->createIndex('idx-equipment_type-status', 'equipment_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_type}}');
    }
}
