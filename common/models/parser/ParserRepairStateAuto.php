<?php

namespace common\models\parser;

use Yii;

/**
 * This is the model class for table "auto_condition".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 *
 * @property AutoCaradv[] $autoCaradvs
 */
class ParserRepairStateAuto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_condition';
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
            [['created_at', 'updated_at', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * Gets query for [[AutoCaradvs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvs()
    {
        return $this->hasMany(AutoCaradv::class, ['condition_id' => 'id']);
    }

}
