<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%home_reject}}`.
 */
class m251124_172813_create_home_reject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_home', 'reject_reason',$this->text());
        $this->addColumn('evalue_home', 'rejected_user_id',$this->integer());
        $this->addColumn('evalue_home', 'rejected_at',$this->integer());
        $this->createTable('{{%home_reject}}', [
            'id' => $this->primaryKey(),
            'evalue_home_id' => $this->integer(),
            'reject_type' => $this->integer(),
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
        $this->createIndex('idx-home_reject-evalue_home_id', 'home_reject', 'evalue_home_id');
        $this->createIndex('idx-home_reject-reject_type', 'home_reject', 'reject_type');
        $this->createIndex('idx-home_reject-is_deleted', 'home_reject', 'is_deleted');
        $this->createIndex('idx-home_reject-status', 'home_reject', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%home_reject}}');
    }
}
