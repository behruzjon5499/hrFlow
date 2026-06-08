<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%map_polygon}}`.
 */
class m260505_000001_create_map_polygon_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%map_polygon}}', [
            'id'                       => $this->primaryKey(),
            'title'                    => $this->string(255),
            'color'                    => $this->string(20)->defaultValue('#1e40af'),
            'zone_category'            => $this->string(50)->defaultValue('residential'),
            'region_id'                => $this->integer(),
            'district_id'              => $this->integer(),
            'primary_neighborhood_id'  => $this->integer(),
            'similar_neighborhood_ids' => $this->text(),   // JSON array of neighborhood IDs
            'coordinates'              => $this->text(),   // JSON GeoJSON coordinates
            'status'                   => $this->smallInteger()->defaultValue(1),
            'order'                    => $this->integer()->defaultValue(0),
            'created_at'               => $this->integer(),
            'created_by'               => $this->integer(),
            'updated_at'               => $this->integer(),
            'updated_by'               => $this->integer(),
            'is_deleted'               => $this->tinyInteger(1),
            'deleted_by'               => $this->integer(),
            'deleted_at'               => $this->integer(),
        ]);

        $this->createIndex('idx-map_polygon-region_id',               'map_polygon', 'region_id');
        $this->createIndex('idx-map_polygon-district_id',             'map_polygon', 'district_id');
        $this->createIndex('idx-map_polygon-primary_neighborhood_id', 'map_polygon', 'primary_neighborhood_id');
        $this->createIndex('idx-map_polygon-is_deleted',              'map_polygon', 'is_deleted');
        $this->createIndex('idx-map_polygon-status',                  'map_polygon', 'status');
    }

    public function safeDown()
    {
        $this->dropTable('{{%map_polygon}}');
    }
}
