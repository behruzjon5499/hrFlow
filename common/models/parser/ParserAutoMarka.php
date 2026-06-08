<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_carmark".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $source
 * @property string $remote_identifier
 * @property string|null $icon_url
 * @property string $alias
 * @property string|null $label_uz
 * @property string|null $label_ru
 *
 * @property AutoCarmodel[] $autoCarmodels
 */
class ParserAutoMarka extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_carmark';
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
            [['icon_url', 'label_uz', 'label_ru'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'source', 'remote_identifier', 'alias'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['source', 'remote_identifier', 'icon_url', 'alias', 'label_uz', 'label_ru'], 'string', 'max' => 100],
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
            'source' => 'Source',
            'remote_identifier' => 'Remote Identifier',
            'icon_url' => 'Icon Url',
            'alias' => 'Alias',
            'label_uz' => 'Label Uz',
            'label_ru' => 'Label Ru',
        ];
    }

    /**
     * Gets query for [[AutoCarmodels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCarmodels()
    {
        return $this->hasMany(AutoCarmodel::class, ['mark_id' => 'id']);
    }

}
