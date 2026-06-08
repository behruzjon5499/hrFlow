<?php

use yii\db\Migration;

class m260507_100003_alter_map_polygon_drop_color_zone extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('{{%map_polygon}}', 'color');
        $this->dropColumn('{{%map_polygon}}', 'zone_category');
    }

    public function safeDown()
    {
        $this->addColumn('{{%map_polygon}}', 'color',         $this->string(32)->defaultValue('#1e40af'));
        $this->addColumn('{{%map_polygon}}', 'zone_category', $this->string(64)->defaultValue('residential'));
    }
}
