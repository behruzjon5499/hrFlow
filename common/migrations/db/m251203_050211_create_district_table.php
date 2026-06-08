<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%district}}`.
 */
class m251203_050211_create_district_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%district}}', [
            'id' => $this->primaryKey(),
            'title_ru' => $this->string(),
            'title_uz' => $this->string(),
            'title_oz' => $this->string(),
            'region_id' => $this->integer(),
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
        $this->createIndex('idx-district-region_id', 'district', 'region_id');
        $this->createIndex('idx-district-soato_id', 'district', 'soato_id');
        $this->createIndex('idx-district-is_deleted', 'district', 'is_deleted');
        $this->createIndex('idx-district-order', 'district', 'order');
        $this->createIndex('idx-district-status', 'district', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%district}}');
    }
}
