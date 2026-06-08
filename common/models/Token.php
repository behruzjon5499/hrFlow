<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property string|null $token
 * @property int|null $user_id
 * @property int|null $type
 * @property int|null $expired_at
 * @property int|null $status
 * @property int|null $created_at
 */
class Token extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE =1;
    const STATUS_INACTIVE =0;


    const TYPE_EMAIL =1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'expired_at', 'status', 'created_at'], 'default', 'value' => null],
            [['user_id', 'type', 'expired_at', 'status', 'created_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'user_id' => 'User ID',
            'type' => 'Type',
            'expired_at' => 'Expired At',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
