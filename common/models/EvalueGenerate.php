<?php

namespace common\models;

use api\modules\common\resources\FileResource;
use Yii;

/**
 * This is the model class for table "evalue_generate".
 *
 * @property int $id
 * @property int|null $fileable_id
 * @property string|null $fileable_type
 * @property float|null $sum
 * @property string|null $data
 * @property int|null $order
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 * @property int|null $sum_one_area
 * @property int|null $area_result_sum
 * @property int|null $rent_sum
 * @property int|null $currency
 * @property int|null $description
 */
class EvalueGenerate extends  ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_generate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fileable_id', 'fileable_type', 'data', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['fileable_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['fileable_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['sum'], 'number'],
            [['data','sum_one_area','area_result_sum','rent_sum','currency','description'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['fileable_type'], 'string', 'max' => 255],
        ];
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['files'] = 'files';
        return $extraFields;
    }
    public function getFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type' => File::TYPE_GENERATE_FILE])->andWhere(['fileable_type' => EvalueGenerate::className()])->orderBy(['id' => SORT_DESC]);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fileable_id' => 'Fileable ID',
            'fileable_type' => 'Fileable Type',
            'sum' => 'Sum',
            'data' => 'Data',
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
    public function beforeSave($insert)
    {
        if ($this->sum < 0) {
            $this->sum = 0;
        }

        return parent::beforeSave($insert);
    }
}
