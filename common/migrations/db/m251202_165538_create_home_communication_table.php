<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_communication}}`.
 */
class m251202_165538_create_home_communication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%home_communication}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'communication_id' => $this->integer(),
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
        $this->createIndex('idx-home_communication-evalue_home_id', 'home_communication', 'evalue_home_id');
        $this->createIndex('idx-home_communication-communication_id', 'home_communication', 'communication_id');
        $this->createIndex('idx-home_communication-is_deleted', 'home_communication', 'is_deleted');
        $this->createIndex('idx-home_communication-status', 'home_communication', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_communication}}');
    }
}
