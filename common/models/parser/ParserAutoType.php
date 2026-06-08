<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_category".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property string|null $label
 * @property string|null $labelRu
 * @property int|null $parent_id
 *
 * @property AutoCaradv[] $autoCaradvs
 * @property ParserAutoType $parent
 * @property ParserAutoType[] $parserAutoTypes
 */
class ParserAutoType extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_category';
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
            [['label', 'labelRu', 'parent_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'integer'],
            [['name', 'label', 'labelRu'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParserAutoType::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'label' => 'Label',
            'labelRu' => 'Label Ru',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * Gets query for [[AutoCaradvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvs()
    {
        return $this->hasMany(AutoCaradv::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ParserAutoType::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[ParserAutoTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParserAutoTypes()
    {
        return $this->hasMany(ParserAutoType::class, ['parent_id' => 'id']);
    }

}
