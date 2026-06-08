<?php

namespace common\models;

/**
 * @property int $id
 * @property int $zone_category_id
 * @property int $neighborhood_id
 *
 * @property ZoneCategory  $zoneCategory
 * @property Neighborhood  $neighborhood
 */
class ZoneCategoryNeighborhood extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'zone_category_neighborhoods';
    }

    public function rules()
    {
        return [
            [['zone_category_id', 'neighborhood_id'], 'required'],
            [['zone_category_id', 'neighborhood_id'], 'integer'],
        ];
    }

    public function getZoneCategory()
    {
        return $this->hasOne(ZoneCategory::class, ['id' => 'zone_category_id']);
    }

    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::class, ['id' => 'neighborhood_id']);
    }
}
