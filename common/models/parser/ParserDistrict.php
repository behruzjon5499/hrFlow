<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "home_district".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 * @property int|null $region_id
 *
 * @property HomeHome[] $homeHomes
 * @property HomeRegion $region
 */
class ParserDistrict extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_district';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('parser');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['region_id'], 'default', 'value' => null],
            [['region_id'], 'integer'],
            [['title'], 'string', 'max' => 300],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => HomeRegion::class, 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'region_id' => 'Region ID',
        ];
    }

    /**
     * Gets query for [[HomeHomes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeHomes()
    {
        return $this->hasMany(HomeHome::class, ['district_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(HomeRegion::class, ['id' => 'region_id']);
    }

}
