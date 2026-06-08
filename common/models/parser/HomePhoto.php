<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "home_homephoto".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $photo
 * @property int|null $home_id
 *
 * @property HomeHome $home
 */
class HomePhoto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_homephoto';
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
            [['home_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'photo'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['home_id'], 'default', 'value' => null],
            [['home_id'], 'integer'],
            [['photo'], 'string', 'max' => 500],
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
            'photo' => 'Photo',
            'home_id' => 'Home ID',
        ];
    }

    /**
     * Gets query for [[Home]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHome()
    {
        return $this->hasOne(HomeHome::class, ['id' => 'home_id']);
    }

}
