<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_count_by_day_view".
 *
 * @property string|null $day
 * @property int|null $home
 * @property int|null $auto
 * @property int|null $equipment
 */
class EvalueCountByDayView extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_count_by_day_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['day', 'home', 'auto', 'equipment'], 'default', 'value' => null],
            [['day'], 'string'],
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
            'day' => 'Day',
            'home' => 'Home',
            'auto' => 'Auto',
            'equipment' => 'Equipment',
        ];
    }

}
