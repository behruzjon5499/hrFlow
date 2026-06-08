<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_region".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $name
 * @property string $alias
 *
 * @property AutoCaradv[] $autoCaradvs
 * @property AutoDistrict[] $autoDistricts
 */
class ParserAutoRegion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_region';
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
            [['name'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'alias'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'alias'], 'string', 'max' => 100],
            [['alias'], 'unique'],
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
        ];
    }

    /**
     * Gets query for [[AutoCaradvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvs()
    {
        return $this->hasMany(AutoCaradv::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[AutoDistricts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoDistricts()
    {
        return $this->hasMany(AutoDistrict::class, ['region_id' => 'id']);
    }

}
