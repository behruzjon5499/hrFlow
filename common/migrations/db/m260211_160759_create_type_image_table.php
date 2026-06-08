<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%type_image}}`.
 */
class m260211_160759_create_type_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%type_image}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'type_id' => $this->integer(),
            'title' => $this->string(),
            'image_id' => $this->integer(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'is_deleted' => $this->boolean(),
            'deleted_by' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%type_image}}');
    }
}
