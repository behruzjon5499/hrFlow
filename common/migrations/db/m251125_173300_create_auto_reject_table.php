<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auto_reject}}`.
 */
class m251125_173300_create_auto_reject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('evalue_auto', 'reject_reason',$this->text());
        $this->addColumn('evalue_auto', 'rejected_user_id',$this->integer());
        $this->addColumn('evalue_auto', 'rejected_at',$this->integer());
        $this->createTable('{{%auto_reject}}', [
            'id' => $this->primaryKey(),
            'evalue_auto_id' => $this->integer(),
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
        $this->createIndex('idx-auto_reject-evalue_auto_id', 'auto_reject', 'evalue_auto_id');
        $this->createIndex('idx-auto_reject-reject_type', 'auto_reject', 'reject_type');
        $this->createIndex('idx-auto_reject-is_deleted', 'auto_reject', 'is_deleted');
        $this->createIndex('idx-auto_reject-status', 'auto_reject', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%auto_reject}}');
    }
}
