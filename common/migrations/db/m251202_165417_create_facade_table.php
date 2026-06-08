<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%facade}}`.
 */
class m251202_165417_create_facade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%facade}}', [
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
        $this->createIndex('idx-facade-key', 'facade', 'key');
        $this->createIndex('idx-facade-is_deleted', 'facade', 'is_deleted');
        $this->createIndex('idx-facade-order', 'facade', 'order');
        $this->createIndex('idx-facade-status', 'facade', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%facade}}');
    }
}
