<?php

namespace common\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * @property int         $id
 * @property string      $title
 * @property string|null $color
 * @property int|null    $region_id
 * @property int|null    $district_id
 * @property float|null  $price_from
 * @property float|null  $price_to
 * @property int|null    $deleted_at
 * @property int|null    $deleted_by
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 *
 * @property Region|null       $region
 * @property District|null     $district
 * @property Neighborhood[]    $neighborhoods
 */
class ZoneCategory extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'zone_category';
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
            [['title'], 'required'],
            [['title', 'color'], 'string', 'max' => 255],
            [['region_id', 'district_id'], 'integer'],
            [['price_from', 'price_to'], 'number', 'min' => 0],
            [['color'], 'default', 'value' => '#1e40af'],
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

    public function getNeighborhoodLinks()
    {
        return $this->hasMany(ZoneCategoryNeighborhood::class, ['zone_category_id' => 'id']);
    }

    public function getNeighborhoods()
    {
        return $this->hasMany(Neighborhood::class, ['id' => 'neighborhood_id'])
            ->via('neighborhoodLinks');
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Nomi',
            'color'       => 'Rang',
            'region_id'   => 'Viloyat',
            'district_id' => 'Tuman',
            'price_from'  => 'Narx (dan)',
            'price_to'    => 'Narx (gacha)',
            'status'      => 'Status',
            'created_at'  => 'Yaratilgan',
            'updated_at'  => 'Yangilangan',
        ];
    }
}
