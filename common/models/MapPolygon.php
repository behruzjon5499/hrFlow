<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "map_polygon".
 *
 * @property int         $id
 * @property int|null    $region_id
 * @property int|null    $district_id
 * @property int|null    $primary_neighborhood_id
 * @property string|null $coordinates               JSON GeoJSON
 * @property int|null    $status
 * @property int|null    $order
 * @property int|null    $created_at
 * @property int|null    $created_by
 * @property int|null    $updated_at
 * @property int|null    $updated_by
 * @property int|null    $is_deleted
 * @property int|null    $deleted_by
 * @property int|null    $deleted_at
 */
class MapPolygon extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'map_polygon';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['region_id', 'district_id', 'primary_neighborhood_id', 'status', 'order',
              'deleted_by', 'deleted_at', 'is_deleted'], 'integer'],
            [['coordinates'], 'string'],
            [['status'], 'default', 'value' => 1],
            [['coordinates'], 'required'],
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }

    public function getPrimaryNeighborhood()
    {
        return $this->hasOne(Neighborhood::class, ['id' => 'primary_neighborhood_id']);
    }

    public function attributeLabels()
    {
        return [
            'id'                      => 'ID',
            'region_id'               => 'Viloyat',
            'district_id'             => 'Tuman',
            'primary_neighborhood_id' => 'Asosiy joylashuv',
            'coordinates'             => 'Koordinatalar',
            'status'                  => 'Status',
            'order'                   => 'Tartib',
            'created_at'              => 'Yaratilgan',
            'created_by'              => 'Yaratdi',
            'updated_at'              => 'Yangilangan',
            'updated_by'              => 'Yangiladi',
            'is_deleted'              => 'O\'chirilgan',
        ];
    }
}
