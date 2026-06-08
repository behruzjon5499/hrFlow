<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_has_detail}}`.
 */
class m251124_160850_create_home_has_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_has_detail}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'has_detail_id' => $this->integer(),
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
        $this->createIndex('idx-home_has_detail-evalue_home_id', 'home_has_detail', 'evalue_home_id');
        $this->createIndex('idx-home_has_detail-has_detail_id', 'home_has_detail', 'has_detail_id');
        $this->createIndex('idx-home_has_detail-is_deleted', 'home_has_detail', 'is_deleted');
        $this->createIndex('idx-home_has_detail-status', 'home_has_detail', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_has_detail}}');
    }
}
