<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%building_material}}`.
 */
class m251118_174027_create_building_material_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%building_material}}', [
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
        $this->createIndex('idx-building_material-key', 'building_material', 'key');
        $this->createIndex('idx-building_material-is_deleted', 'building_material', 'is_deleted');
        $this->createIndex('idx-building_material-order', 'building_material', 'order');
        $this->createIndex('idx-building_material-status', 'building_material', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%building_material}}');
    }
}
