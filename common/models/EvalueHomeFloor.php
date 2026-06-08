<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_home_floor".
 *
 * @property int $id
 * @property int|null $evalue_home_id
 * @property int|null $floor
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 */
class EvalueHomeFloor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_home_floor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_home_id', 'floor', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['evalue_home_id', 'floor', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_home_id', 'floor', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evalue_home_id' => 'Evalue Home ID',
            'floor' => 'Floor',
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
