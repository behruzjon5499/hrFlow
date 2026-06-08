<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "home_reject".
 *
 * @property int $id
 * @property int|null $evalue_home_id
 * @property int|null $reject_type
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
class HomeReject extends ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_reject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['evalue_home_id', 'reject_type', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['evalue_home_id', 'reject_type', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['evalue_home_id', 'reject_type', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['is_deleted'], 'boolean'],
        ];
    }

    public function fields()
    {
        $extraFields = parent::fields();
        $extraFields['title'] = 'title';
        return $extraFields;
    }

    public function getTitle()
    {
        return ArrayHelper::getValue(self::getRejectTypes(), $this->reject_type);
    }

    public static function getRejectTypes()
    {
        return [
            1 => "Hujjatlar yetarli emas",
            2 => "Rasm noaniq",
            3 => "Ma'lumotlar noto'g'ri",
            4 => "Obyektr joylashuvi mos emas",
            5 => "Baholashga yaroqsiz",
            6 => "Noto'g'ri baholangan",
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
            'reject_type' => 'Reject Type',
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
