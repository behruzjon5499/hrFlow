<?php

use yii\db\Migration;

class m260507_100001_create_zone_category extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%zone_category}}', [
            'id'          => $this->primaryKey(),
            'title'       => $this->string(255)->notNull(),
            'color'       => $this->string(32)->defaultValue('#1e40af'),
            'region_id'   => $this->integer()->null(),
            'district_id' => $this->integer()->null(),
            'price_from'  => $this->decimal(15, 2)->null(),
            'price_to'    => $this->decimal(15, 2)->null(),
            'deleted_at'  => $this->integer()->null(),
            'deleted_by'  => $this->integer()->null(),
            'created_at'  => $this->integer()->null(),
            'updated_at'  => $this->integer()->null(),
            'created_by'  => $this->integer()->null(),
            'updated_by'  => $this->integer()->null(),
        ]);

        $this->createIndex('idx_zone_category_region',   '{{%zone_category}}', 'region_id');
        $this->createIndex('idx_zone_category_district', '{{%zone_category}}', 'district_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%zone_category}}');
    }
}
