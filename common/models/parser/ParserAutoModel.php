<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_carmodel".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $remote_identifier
 * @property string|null $source
 * @property string|null $label_uz
 * @property string|null $label_ru
 * @property int|null $mark_id
 *
 * @property AutoCaradv[] $autoCaradvs
 * @property AutoCarmark $mark
 */
class ParserAutoModel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_carmodel';
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
            [['source', 'label_uz', 'label_ru', 'mark_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'remote_identifier'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['mark_id'], 'default', 'value' => null],
            [['mark_id'], 'integer'],
            [['remote_identifier', 'source', 'label_uz', 'label_ru'], 'string', 'max' => 100],
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
            'remote_identifier' => 'Remote Identifier',
            'source' => 'Source',
            'label_uz' => 'Label Uz',
            'label_ru' => 'Label Ru',
            'mark_id' => 'Mark ID',
        ];
    }

    /**
     * Gets query for [[AutoCaradvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvs()
    {
        return $this->hasMany(AutoCaradv::class, ['car_model_id' => 'id']);
    }

    /**
     * Gets query for [[Mark]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(AutoCarmark::class, ['id' => 'mark_id']);
    }

}
