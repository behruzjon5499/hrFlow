<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_plan}}`.
 */
class m251118_175236_create_home_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_plan}}', [
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
        $this->createIndex('idx-home_plan-key', 'home_plan', 'key');
        $this->createIndex('idx-home_plan-is_deleted', 'home_plan', 'is_deleted');
        $this->createIndex('idx-home_plan-order', 'home_plan', 'order');
        $this->createIndex('idx-home_plan-status', 'home_plan', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_plan}}');
    }
}
