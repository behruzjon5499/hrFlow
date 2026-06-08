<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_count_by_month_view".
 *
 * @property string|null $type
 * @property string|null $month_label
 * @property string|null $by_year
 * @property int|null $cnt
 */
class EvalueCountByMonthView extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_count_by_month_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'month_label', 'by_year', 'cnt'], 'default', 'value' => null],
            [['type', 'month_label', 'by_year'], 'string'],
            [['cnt'], 'default', 'value' => null],
            [['cnt'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Type',
            'month_label' => 'Month Label',
            'by_year' => 'By Year',
            'cnt' => 'Cnt',
        ];
    }

}
