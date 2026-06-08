<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_count_by_day_view".
 *
 * @property string|null $year
 * @property int|null $home
 * @property int|null $auto
 * @property int|null $equipment
 */
class EvalueCountByYearView extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_count_by_year_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'home', 'auto', 'equipment'], 'default', 'value' => null],
            [['year'], 'string'],
            [['home', 'auto', 'equipment'], 'default', 'value' => null],
            [['home', 'auto', 'equipment'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year' => 'Year',
            'home' => 'Home',
            'auto' => 'Auto',
            'equipment' => 'Equipment',
        ];
    }

}
