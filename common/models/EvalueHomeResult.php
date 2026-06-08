<?php

namespace common\models;

use common\models\parser\ParserHome;
use Yii;

/**
 * This is the model class for table "evalue_home_result".
 *
 * @property int $id
 * @property int|null $evalue_home_id
 * @property int|null $evalue_generate_id
 * @property float|null $adjusted_sum
 * @property int|null $area_percent
 * @property float|null $area_sum
 * @property string|null $state
 * @property float|null $state_sum
 * @property string|null $floor
 * @property float|null $floor_sum
 * @property float|null $total_adjustment
 * @property float|null $coefficient_count
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
 * @property int|null $parser_home_id
 * @property int|null $begin_percent
 * @property int|null $begin_sum
 * @property int|null $land_percent
 * @property int|null $land_diff_percent
 * @property int|null $land_sum
 */
class EvalueHomeResult extends  ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_home_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_home_id', 'evalue_generate_id', 'adjusted_sum', 'area_percent', 'area_sum', 'state', 'state_sum', 'floor', 'floor_sum', 'total_adjustment', 'intermediate_indicator', 'specific_gravity_percent', 'result_sum', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['evalue_home_id', 'evalue_generate_id', 'area_percent', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_home_id', 'evalue_generate_id',  'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['adjusted_sum', 'area_sum', 'state_sum', 'floor_sum', 'total_adjustment', 'intermediate_indicator', 'specific_gravity_percent', 'result_sum'], 'number'],
            [['is_deleted'], 'boolean'],
            [['coefficient_count','parser_home_id','begin_percent','begin_sum','land_percent','land_sum','land_diff_percent'], 'safe'],
            [['state', 'floor'], 'string', 'max' => 255],
        ];
    }

    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['evalueHome'] = 'evalueHome';
        $extraFields['evalueGenerate'] = 'evalueGenerate';
        $extraFields['parserHome'] = 'parserHome';
        return $extraFields;
    }
    public function getParserHome()
    {
        return $this->hasOne(ParserHome::className(), ['id' => 'parser_home_id']);
    }
    public function getEvalueHome()
    {
        return $this->hasOne(EvalueHome::className(), ['id' => 'evalue_home_id']);
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
            'evalue_home_id' => 'Evalue Home ID',
            'evalue_generate_id' => 'Evalue Generate ID',
            'adjusted_sum' => 'Adjusted Sum',
            'area_percent' => 'Area Percent',
            'area_sum' => 'Area Sum',
            'state' => 'State',
            'state_sum' => 'State Sum',
            'floor' => 'Floor',
            'floor_sum' => 'Floor Sum',
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
