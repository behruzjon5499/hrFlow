<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evalue_view".
 *
 * @property int $id
 * @property int|null $evalue_id
 * @property string|null $type
 * @property int|null $order
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 */
class EvalueView extends  ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_id', 'type', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['evalue_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evalue_id' => 'Evalue ID',
            'type' => 'Type',
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
