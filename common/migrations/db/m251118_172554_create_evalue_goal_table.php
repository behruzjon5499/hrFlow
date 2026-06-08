<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_goal}}`.
 */
class m251118_172554_create_evalue_goal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_goal}}', [
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
        $this->createIndex('idx-evalue_goal-key', 'evalue_goal', 'key');
        $this->createIndex('idx-evalue_goal-is_deleted', 'evalue_goal', 'is_deleted');
        $this->createIndex('idx-evalue_goal-order', 'evalue_goal', 'order');
        $this->createIndex('idx-evalue_goal-status', 'evalue_goal', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_goal}}');
    }
}
