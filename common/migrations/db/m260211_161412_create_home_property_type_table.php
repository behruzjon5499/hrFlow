<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_property_type}}`.
 */
class m260211_161412_create_home_property_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_property_type}}', [
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
        $this->createIndex('idx-home_property_type-key', 'home_property_type', 'key');
        $this->createIndex('idx-home_property_type-is_deleted', 'home_property_type', 'is_deleted');
        $this->createIndex('idx-home_property_type-order', 'home_property_type', 'order');
        $this->createIndex('idx-home_property_type-status', 'home_property_type', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_property_type}}');
    }
}
