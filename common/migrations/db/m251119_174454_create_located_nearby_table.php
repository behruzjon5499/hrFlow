<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%located_nearby}}`.
 */
class m251119_174454_create_located_nearby_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%located_nearby}}', [
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
        $this->createIndex('idx-located_nearby-key', 'located_nearby', 'key');
        $this->createIndex('idx-located_nearby-is_deleted', 'located_nearby', 'is_deleted');
        $this->createIndex('idx-located_nearby-order', 'located_nearby', 'order');
        $this->createIndex('idx-located_nearby-status', 'located_nearby', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%located_nearby}}');
    }
}
