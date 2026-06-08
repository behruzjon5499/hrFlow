<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "home_property_type".
 *
 * @property int $id
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $title_oz
 * @property string|null $key
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
class HomePropertyType extends  ActiveRecord
{
    const TYPE_APARTMENT=1;
    const TYPE_NO_RESIDENCE =2;
    const TYPE_RESIDENCE =3;
    const TYPE_LAND_AREA=4;
    const TYPE_RENT=5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_property_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_ru', 'title_uz', 'title_oz', 'key', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['title_ru', 'title_uz', 'title_oz', 'key'], 'string', 'max' => 255],
        ];
    }
    public function extraFields()
    {
        $fields = parent::extraFields();
        $fields['typeImages'] = 'typeImages';
        return $fields;
    }
    public function getTypeImages()
    {
        return $this->hasMany(TypeImage::class,['type_id'=>'id'])->andWhere(['type'=>self::class]);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Title Ru',
            'title_uz' => 'Title Uz',
            'title_oz' => 'Title Oz',
            'key' => 'Key',
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
