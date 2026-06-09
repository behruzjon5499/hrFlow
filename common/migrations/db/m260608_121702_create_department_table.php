<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%department}}`.
 */
class m260608_121702_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%department}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'title' => $this->string(),
            'title_ru' => $this->string(),
            'uid' => $this->integer(),
            'root_department_id' => $this->integer(),
            'tin' => $this->string(20),
            'status' => $this->integer()->defaultValue(1)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted_by' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false)->notNull(),
        ]);
        $this->createIndex('idx_department_uid', '{{%department}}', 'uid');
        $this->createIndex('idx_department_parent_id', '{{%department}}', 'parent_id');
        $this->createIndex('idx_department_title', '{{%department}}', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%department}}');
    }
}
