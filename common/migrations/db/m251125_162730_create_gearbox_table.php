<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gearbox}}`.
 */
class m251125_162730_create_gearbox_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gearbox}}', [
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
        $this->createIndex('idx-gearbox-key', 'gearbox', 'key');
        $this->createIndex('idx-gearbox-is_deleted', 'gearbox', 'is_deleted');
        $this->createIndex('idx-gearbox-order', 'gearbox', 'order');
        $this->createIndex('idx-gearbox-status', 'gearbox', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gearbox}}');
    }
}
