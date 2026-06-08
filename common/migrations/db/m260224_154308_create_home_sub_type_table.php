<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_sub_type}}`.
 */
class m260224_154308_create_home_sub_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_sub_type}}', [
            'id' => $this->primaryKey(),
            'home_type_id' => $this->integer(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'key' => $this->string(),
            'extra_ids' => $this->json(),
            'extra_auto_ids' => $this->json(),
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
        $this->createIndex('idx-home_sub_type-key', 'home_sub_type', 'key');
        $this->createIndex('idx-home_sub_type-is_deleted', 'home_sub_type', 'is_deleted');
        $this->createIndex('idx-home_sub_type-order', 'home_sub_type', 'order');
        $this->createIndex('idx-home_sub_type-status', 'home_sub_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_sub_type}}');
    }
}
