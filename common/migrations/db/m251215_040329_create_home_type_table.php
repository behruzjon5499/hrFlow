<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_type}}`.
 */
class m251215_040329_create_home_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_type}}', [
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
            'type' => $this->integer(),
        ]);
        $this->createIndex('idx-home_type-key', 'home_type', 'key');
        $this->createIndex('idx-home_type-extra_ids', 'home_type', 'extra_ids');
        $this->createIndex('idx-home_type-is_deleted', 'home_type', 'is_deleted');
        $this->createIndex('idx-home_type-order', 'home_type', 'order');
        $this->createIndex('idx-home_type-status', 'home_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_type}}');
    }
}
