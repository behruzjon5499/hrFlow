<?php

namespace common\models;

use common\models\parser\ParserAuto;
use Yii;

/**
 * This is the model class for table "evalue_auto_result".
 *
 * @property int $id
 * @property int|null $evalue_auto_id
 * @property int|null $evalue_generate_id
 * @property float|null $adjusted_sum
 * @property int|null $year_percent
 * @property float|null $year_sum
 * @property string|null $km
 * @property string|null $omega
 * @property float|null $age_and_mileage
 * @property float|null $difference
 * @property float|null $difference_round
 * @property float|null $km_sum
 * @property string|null $state_percent
 * @property float|null $state_sum
 * @property float|null $coefficient_count
 * @property float|null $total_adjustment
 * @property float|null $intermediate_indicator
 * @property float|null $specific_gravity_percent
 * @property float|null $result_sum
 * @property int|null $order
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 * @property int|null $parser_auto_id
 * @property int|null $begin_percent
 * @property int|null $begin_sum
 */
class EvalueAutoResult extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_auto_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_auto_id', 'evalue_generate_id', 'adjusted_sum', 'year_percent', 'year_sum', 'km', 'omega', 'age_and_mileage', 'difference', 'difference_round', 'km_sum', 'state_percent', 'state_sum', 'total_adjustment', 'intermediate_indicator', 'specific_gravity_percent', 'result_sum', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['evalue_auto_id', 'evalue_generate_id', 'year_percent', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_auto_id', 'evalue_generate_id', 'year_percent', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['adjusted_sum', 'year_sum', 'age_and_mileage', 'difference', 'difference_round', 'km_sum', 'state_sum', 'total_adjustment', 'intermediate_indicator', 'specific_gravity_percent', 'result_sum'], 'number'],
            [['is_deleted'], 'boolean'],
            [['coefficient_count','parser_auto_id','begin_percent','begin_sum'], 'safe'],
            [['km', 'omega', 'state_percent'], 'string', 'max' => 255],
        ];
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['evalueAuto'] = 'evalueAuto';
        $extraFields['evalueGenerate'] = 'evalueGenerate';
        $extraFields['parserAuto'] = 'parserAuto';
        return $extraFields;
    }
    public function getParserAuto()
    {
        return $this->hasOne(ParserAuto::className(), ['id' => 'parser_auto_id']);
    }
    public function getEvalueAuto()
    {
        return $this->hasOne(EvalueAuto::className(), ['id' => 'evalue_auto_id']);
    }
    public function getEvalueGenerate()
    {
        return $this->hasOne(EvalueGenerate::className(), ['id' => 'evalue_generate_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evalue_auto_id' => 'Evalue Home ID',
            'evalue_generate_id' => 'Evalue Generate ID',
            'adjusted_sum' => 'Adjusted Sum',
            'year_percent' => 'Year Percent',
            'year_sum' => 'Year Sum',
            'km' => 'Km',
            'omega' => 'Omega',
            'age_and_mileage' => 'Age And Mileage',
            'difference' => 'Difference',
            'difference_round' => 'Difference Round',
            'km_sum' => 'Km Sum',
            'state_percent' => 'State Percent',
            'state_sum' => 'State Sum',
            'total_adjustment' => 'Total Adjustment',
            'intermediate_indicator' => 'Intermediate Indicator',
            'specific_gravity_percent' => 'Specific Gravity Percent',
            'result_sum' => 'Result Sum',
            'order' => 'Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
            'deleted_by' => 'Deleted By',
            'deleted_at' => 'Deleted At',
        ];
    }

}
