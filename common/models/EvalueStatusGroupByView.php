<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_status_group_by_view".
 *
 * @property string|null $type
 * @property int|null $status
 * @property int|null $cnt
 * @property int|null $created_by
 */
class EvalueStatusGroupByView extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_status_group_by_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status', 'cnt'], 'default', 'value' => null],
            [['type'], 'string'],
            [['status', 'cnt'], 'default', 'value' => null],
            [['status', 'cnt','created_by'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Type',
            'status' => 'Status',
            'cnt' => 'Cnt',
        ];
    }

}
