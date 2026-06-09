<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $title
 * @property string|null $title_ru
 * @property int|null $uid
 * @property int|null $root_department_id
 * @property string|null $tin
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property bool $is_deleted
 */
class Department extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'title', 'title_ru', 'uid', 'root_department_id', 'tin', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['is_deleted'], 'default', 'value' => 0],
            [['parent_id', 'uid', 'root_department_id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'default', 'value' => null],
            [['parent_id', 'uid', 'root_department_id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['title', 'title_ru'], 'string', 'max' => 255],
            [['tin'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'title_ru' => 'Title Ru',
            'uid' => 'Uid',
            'root_department_id' => 'Root Department ID',
            'tin' => 'Tin',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'deleted_by' => 'Deleted By',
            'is_deleted' => 'Is Deleted',
        ];
    }

}
