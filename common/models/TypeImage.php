<?php

namespace common\models;

use api\modules\common\resources\FileResource;
use Yii;

/**
 * This is the model class for table "type_image".
 *
 * @property int $id
 * @property int|null $type
 * @property int|null $type_id
 * @property string|null $title
 * @property int|null $image_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 * @property int|null $order
 */
class TypeImage extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[  'type_id', 'title', 'image_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [[ 'type_id', 'image_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [[ 'type_id', 'image_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['order'], 'safe'],
            [['title','type'], 'string', 'max' => 255],
        ];
    }

    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields['image'] = 'image';
        return $fields;
    }

    public function getImage()
    {
        return $this->hasOne(FileResource::class, ['id' => 'image_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'title' => 'Title',
            'image_id' => 'Image ID',
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
