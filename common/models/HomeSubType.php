<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "home_sub_type".
 *
 * @property int $id
 * @property int|null $home_type_id
 * @property string|null $title_ru
 * @property string|null $title_uz
 * @property string|null $title_oz
 * @property string|null $key
 * @property string|null $extra_ids
 * @property string|null $extra_auto_ids
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
class HomeSubType extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_sub_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['home_type_id', 'title_ru', 'title_uz', 'title_oz', 'key', 'extra_ids', 'extra_auto_ids', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['home_type_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['home_type_id', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['extra_ids', 'extra_auto_ids'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['title_ru', 'title_uz', 'title_oz', 'key'], 'string', 'max' => 255],
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
    public function extraFields()
    {
        $fields = parent::fields();
        $fields['homeType'] = 'homeType';
        return $fields;
    }
    public function getHomeType()
    {
        return $this->hasOne(HomeType::className(), ['id' => 'home_type_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'home_type_id' => 'Home Type ID',
            'title_ru' => 'Title Ru',
            'title_uz' => 'Title Uz',
            'title_oz' => 'Title Oz',
            'key' => 'Key',
            'extra_ids' => 'Extra Ids',
            'extra_auto_ids' => 'Extra Auto Ids',
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
