<?php

use yii\db\Migration;

class m260507_100002_create_zone_category_neighborhoods extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%zone_category_neighborhoods}}', [
            'id'               => $this->primaryKey(),
            'zone_category_id' => $this->integer()->notNull(),
            'neighborhood_id'  => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_zcn_zone',         '{{%zone_category_neighborhoods}}', 'zone_category_id');
        $this->createIndex('idx_zcn_neighborhood',  '{{%zone_category_neighborhoods}}', 'neighborhood_id');
        $this->createIndex('idx_zcn_unique',        '{{%zone_category_neighborhoods}}', ['zone_category_id', 'neighborhood_id'], true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%zone_category_neighborhoods}}');
    }
}
