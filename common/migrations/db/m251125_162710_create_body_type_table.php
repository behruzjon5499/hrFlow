<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%body_type}}`.
 */
class m251125_162710_create_body_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%body_type}}', [
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
        $this->createIndex('idx-body_type-key', 'body_type', 'key');
        $this->createIndex('idx-body_type-is_deleted', 'body_type', 'is_deleted');
        $this->createIndex('idx-body_type-order', 'body_type', 'order');
        $this->createIndex('idx-body_type-status', 'body_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%body_type}}');
    }
}
