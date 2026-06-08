<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'i18n_source_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['message'], 'required', 'message' => t('{attribute} yuborish majburiy')],
            [['message'], 'string'],
            [['message'], 'unique'],
            [['category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'category' => Yii::t('yii', 'Category'),
            'message' => Yii::t('yii', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['id' => 'id']);
    }
}
