<?php

namespace common\models;

use common\traits\NotDeleted;
use common\traits\SoftDelete;
use Yii;
use common\components\ActiveRecordMeta;
/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $path
 * @property int|null $size
 * @property int|null $type
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $fileable_id
 * @property int|null $fileable_type
 *
 */
class File extends ActiveRecordMeta
{
    use SoftDelete;

    const TYPE_IMAGE=1;
    const TYPE_CADASTRE_FILE=2;
    const TYPE_TEX_PASSPORT_FILE=3;
    const TYPE_AUTO_IMAGE=4;
    const TYPE_EQUIPMENT_FILES=5;
    const TYPE_EQUIPMENT_IMAGE=6;
    const TYPE_AVATAR_IMAGE=7;
    const TYPE_GENERATE_FILE=8;
    const TYPE_PASSPORT_FILE=8;
    const TYPE_IMAGE_PLACEHOLDER=9;
    const TYPE_AUTO_PASSPORT_FILE=10;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'path' => Yii::t('main', 'Path'),
            'size' => Yii::t('main', 'Size'),
            'type' => Yii::t('main', 'Type'),
            'status' => Yii::t('main', 'Status'),
            'created_at' => Yii::t('main', 'Created At'),
            'updated_at' => Yii::t('main', 'Updated At'),
            'deleted_at' => Yii::t('main', 'Deleted At'),
            'created_by' => Yii::t('main', 'Created By'),
            'updated_by' => Yii::t('main', 'Updated By'),
        ];
    }


}
