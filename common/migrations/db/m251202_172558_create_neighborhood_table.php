<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%neighborhood}}`.
 */
class m251202_172558_create_neighborhood_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%neighborhood}}', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'district_id' => $this->integer(),
            'soato_id' => $this->integer(),
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
        $this->createIndex('idx-neighborhood-district_id', 'neighborhood', 'district_id');
        $this->createIndex('idx-neighborhood-soato_id', 'neighborhood', 'soato_id');
        $this->createIndex('idx-neighborhood-is_deleted', 'neighborhood', 'is_deleted');
        $this->createIndex('idx-neighborhood-order', 'neighborhood', 'order');
        $this->createIndex('idx-neighborhood-status', 'neighborhood', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%neighborhood}}');
    }
}
