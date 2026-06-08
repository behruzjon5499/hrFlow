<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%has_detail}}`.
 */
class m251119_171821_create_has_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%has_detail}}', [
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
        $this->createIndex('idx-has_detail-key', 'has_detail', 'key');
        $this->createIndex('idx-has_detail-is_deleted', 'has_detail', 'is_deleted');
        $this->createIndex('idx-has_detail-order', 'has_detail', 'order');
        $this->createIndex('idx-has_detail-status', 'has_detail', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%has_detail}}');
    }
}
