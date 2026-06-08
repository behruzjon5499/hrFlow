<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_caradvphotos".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $photo_link
 * @property int|null $adv_id
 *
 * @property AutoCaradv $adv
 */
class AutoPhoto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_caradvphotos';
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
            [['photo_link', 'adv_id'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['adv_id'], 'default', 'value' => null],
            [['adv_id'], 'integer'],
            [['photo_link'], 'string', 'max' => 500],
            [['adv_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoCaradv::class, 'targetAttribute' => ['adv_id' => 'id']],
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
            'photo_link' => 'Photo Link',
            'adv_id' => 'Adv ID',
        ];
    }

    /**
     * Gets query for [[Adv]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdv()
    {
        return $this->hasOne(AutoCaradv::class, ['id' => 'adv_id']);
    }

}
