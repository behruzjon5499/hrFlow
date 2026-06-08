<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%region}}`.
 */
class m251126_155958_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_en' => $this->string(),
            'type' => $this->integer(),
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
        $this->createIndex('idx-region-parent_id', 'region', 'parent_id');
        $this->createIndex('idx-region-type', 'region', 'type');
        $this->createIndex('idx-region-is_deleted', 'region', 'is_deleted');
        $this->createIndex('idx-region-order', 'region', 'order');
        $this->createIndex('idx-region-status', 'region', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%region}}');
    }
}
