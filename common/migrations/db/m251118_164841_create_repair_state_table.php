<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%repair_state}}`.
 */
class m251118_164841_create_repair_state_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%repair_state}}', [
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
        $this->createIndex('idx-repair_state-key', 'repair_state', 'key');
        $this->createIndex('idx-repair_state-is_deleted', 'repair_state', 'is_deleted');
        $this->createIndex('idx-repair_state-order', 'repair_state', 'order');
        $this->createIndex('idx-repair_state-status', 'repair_state', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%repair_state}}');
    }
}
