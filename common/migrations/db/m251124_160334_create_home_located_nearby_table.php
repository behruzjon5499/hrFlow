<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_located_nearby}}`.
 */
class m251124_160334_create_home_located_nearby_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_located_nearby}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'located_nearby_id' => $this->integer(),
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
        $this->createIndex('idx-home_located_nearby-evalue_home_id', 'home_located_nearby', 'evalue_home_id');
        $this->createIndex('idx-home_located_nearby-located_nearby_id', 'home_located_nearby', 'located_nearby_id');
        $this->createIndex('idx-home_located_nearby-is_deleted', 'home_located_nearby', 'is_deleted');
        $this->createIndex('idx-home_located_nearby-status', 'home_located_nearby', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_located_nearby}}');
    }
}
