<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%evalue_generate}}`.
 */
class m251215_061304_create_evalue_generate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%evalue_generate}}', [
            'id' => $this->primaryKey(),
            'fileable_id' => $this->integer(),
            'fileable_type' => $this->string(),
            'sum' => $this->decimal(20,2)->defaultValue(0),
            'data' => $this->json(),
            'order' => $this->integer(),
            'status' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('idx-evalue_generate-sum', 'evalue_generate', 'sum');
        $this->createIndex('idx-evalue_generate-fileable_id', 'evalue_generate', 'fileable_id');
        $this->createIndex('idx-evalue_generate-fileable_type', 'evalue_generate', 'fileable_type');
        $this->createIndex('idx-evalue_generate-is_deleted', 'evalue_generate', 'is_deleted');
        $this->createIndex('idx-evalue_generate-status', 'evalue_generate', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%evalue_generate}}');
    }
}
