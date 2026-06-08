<?php

use yii\db\Migration;

class m260507_100004_alter_map_polygon_drop_title_similar extends Migration
{
    public function up()
    {
        $this->dropColumn('map_polygon', 'title');
        $this->dropColumn('map_polygon', 'similar_neighborhood_ids');
    }

    public function down()
    {
        $this->addColumn('map_polygon', 'title', $this->string(255)->null()->after('id'));
        $this->addColumn('map_polygon', 'similar_neighborhood_ids', $this->text()->null()->after('primary_neighborhood_id'));
    }
}
