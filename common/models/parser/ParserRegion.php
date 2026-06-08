<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "home_region".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 *
 * @property HomeDistrict[] $homeDistricts
 */
class ParserRegion extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_region';
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
            [['created_at', 'updated_at', 'title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 300],
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
        ];
    }

    /**
     * Gets query for [[HomeDistricts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeDistricts()
    {
        return $this->hasMany(HomeDistrict::class, ['region_id' => 'id']);
    }

}
