<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auto_has_detail".
 *
 * @property int $id
 * @property int|null $evalue_auto_id
 * @property int|null $has_detail_id
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
class AutoHasDetail extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_has_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_auto_id', 'has_detail_id', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['evalue_auto_id', 'has_detail_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_auto_id', 'has_detail_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
        ];
    }
    public function getTitle()
    {
        $title = 'title_' . Yii::$app->language;
        return $this->attributes[$title];
    }
    public function fields()
    {
        $fields = parent::fields();
        $fields['title'] = 'title';
        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'evalue_auto_id' => 'Evalue Auto ID',
            'has_detail_id' => 'Has Detail ID',
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
