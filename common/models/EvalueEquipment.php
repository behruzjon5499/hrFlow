<?php

namespace common\models;

use api\modules\common\resources\FileResource;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "evalue_equipment".
 *
 * @property int $id
 * @property int|null $client_type
 * @property int|null $evalue_goal_id
 * @property string|null $full_name
 * @property string|null $client_phone
 * @property string|null $bank_phone
 * @property string|null $passport
 * @property string|null $client_uid
 * @property int|null $equipment_type_id
 * @property string|null $description
 * @property string|null $reject_reason
 * @property int|null $rejected_user_id
 * @property int|null $rejected_at
 * @property float|null $price
 * @property string|null $currency
 * @property int|null $order
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 * @property int|null $estimated_price
 */
class EvalueEquipment extends  ActiveRecord
{
    const STATUS_NEW=1;
    const STATUS_MODERATION=2;
    const STATUS_CONFIRM=3;
    const STATUS_REJECT=4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evalue_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_type', 'evalue_goal_id', 'full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid', 'equipment_type_id', 'description', 'reject_reason', 'rejected_user_id', 'rejected_at', 'price', 'currency', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['client_type', 'evalue_goal_id', 'equipment_type_id', 'rejected_user_id', 'rejected_at', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['client_type', 'evalue_goal_id', 'equipment_type_id', 'rejected_user_id', 'rejected_at', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['description', 'reject_reason','title'], 'string'],
            [['price'], 'number'],
            [['is_deleted'], 'default', 'value' => false],
            [['is_deleted'], 'boolean'],
            [['estimated_price'], 'safe'],
            [['full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid', 'currency'], 'string', 'max' => 255],
        ];
    }
    public function fields()
    {
        $fields = parent::fields();
        $fields['isCanDelete'] = 'isCanDelete';
        $fields['isCanUpdate'] = 'isCanUpdate';
        return $fields;
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['statusName'] = 'statusName';
        $extraFields['hasDetail'] = 'hasDetail';
        $extraFields['locatedNearby'] = 'locatedNearby';
        $extraFields['createdBy'] = 'createdBy';
        $extraFields['evalueGoal'] = 'evalueGoal';
        $extraFields['equipmentImages'] = 'equipmentImages';
        $extraFields['equipmentFiles'] = 'equipmentFiles';
        $extraFields['rejectTypes'] = 'rejectTypes';
        $extraFields['rejectedUser'] = 'rejectedUser';
        $extraFields['equipmentType'] = 'equipmentType';
        $extraFields['evalueGenerate'] = 'evalueGenerate';
        $extraFields['evalueGenerateSum'] = function() {
            return $this->evalueGenerateSum ? $this->evalueGenerateSum->sum : 0;
        };
        return $extraFields;
    }
    public function getEvalueGoal()
    {
        return $this->hasOne(EvalueGoal::className(), ['id' => 'evalue_goal_id']);
    }
    public function getEvalueGenerate()
    {
        return $this->hasOne(EvalueGenerate::className(), ['fileable_id' => 'id'])->andWhere(['fileable_type' => EvalueEquipment::className()])->orderBy(['id' => SORT_DESC]);
    }
    public function getEquipmentType()
    {
        return $this->hasOne(EquipmentType::className(), ['id' => 'equipment_type_id']);
    }
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statusList(),$this->status);
    }
    public function getRejectTypes()
    {
        return $this->hasMany(EquipmentReject::className(), ['evalue_equipment_id' => 'id']);
    }
    public function getRejectedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'rejected_user_id']);
    }
    public function getEquipmentImages()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_EQUIPMENT_IMAGE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getEquipmentFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_EQUIPMENT_FILES])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getEvalueGenerateSum()
    {
        return $this->hasOne(EvalueGenerate::class, ['fileable_id' => 'id'])
            ->andWhere(['fileable_type' => self::class])
            ->select(['id', 'fileable_id', 'fileable_type', 'sum']); // faqat sum!
    }
    public function getIsCanUpdate()
    {
        return $this->status == self::STATUS_NEW;
    }
    public function getIsCanDelete()
    {
        return $this->status == self::STATUS_NEW;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_type' => 'Client Type',
            'evalue_goal_id' => 'Evalue Goal ID',
            'full_name' => 'Full Name',
            'client_phone' => 'Client Phone',
            'bank_phone' => 'Bank Phone',
            'passport' => 'Passport',
            'client_uid' => 'Client Uid',
            'equipment_type_id' => 'Equipment Type ID',
            'description' => 'Description',
            'reject_reason' => 'Reject Reason',
            'rejected_user_id' => 'Rejected User ID',
            'rejected_at' => 'Rejected At',
            'price' => 'Price',
            'currency' => 'Currency',
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
    public static function statusList()
    {
        return[
            self::STATUS_NEW=>"Yangi",
            self::STATUS_MODERATION=>"Moderatsiyada",
            self::STATUS_CONFIRM=>"Tasdiqlangan",
            self::STATUS_REJECT=>"Rad etilgan",
        ];
    }
}
