<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%engine_size}}`.
 */
class m260106_041937_create_engine_size_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%engine_size}}', [
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
        $this->createIndex('idx-engine_size-key', 'engine_size', 'key');
        $this->createIndex('idx-engine_size-is_deleted', 'engine_size', 'is_deleted');
        $this->createIndex('idx-engine_size-order', 'engine_size', 'order');
        $this->createIndex('idx-engine_size-status', 'engine_size', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%engine_size}}');
    }
}
