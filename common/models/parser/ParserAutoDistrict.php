<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_district".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $name
 * @property string $alias
 * @property int|null $region_id
 *
 * @property AutoCaradv[] $autoCaradvs
 * @property AutoRegion $region
 */
class ParserAutoDistrict extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_district';
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
            [['name', 'region_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'alias'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['region_id'], 'default', 'value' => null],
            [['region_id'], 'integer'],
            [['name', 'alias'], 'string', 'max' => 100],
            [['alias'], 'unique'],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoRegion::class, 'targetAttribute' => ['region_id' => 'id']],
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
            'name' => 'Name',
            'alias' => 'Alias',
            'region_id' => 'Region ID',
        ];
    }

    /**
     * Gets query for [[AutoCaradvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvs()
    {
        return $this->hasMany(AutoCaradv::class, ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(AutoRegion::class, ['id' => 'region_id']);
    }

}
