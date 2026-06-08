<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "home_houselayout".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 * @property string|null $code
 *
 * @property HomeHome[] $homeHomes
 */
class ParserHomePlan extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_houselayout';
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
            [['code'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'title'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 300],
            [['code'], 'string', 'max' => 100],
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
            'code' => 'Code',
        ];
    }

    /**
     * Gets query for [[HomeHomes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeHomes()
    {
        return $this->hasMany(HomeHome::class, ['house_layout_id' => 'id']);
    }

}
