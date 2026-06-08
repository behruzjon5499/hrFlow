<?php

namespace common\models;

use api\modules\common\resources\FileResource;
use Random\Engine;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "evalue_auto".
 *
 * @property int $id
 * @property int|null $client_type
 * @property int|null $evalue_goal_id
 * @property string|null $full_name
 * @property string|null $client_phone
 * @property string|null $bank_phone
 * @property string|null $passport
 * @property string|null $client_uid
 * @property int|null $auto_type_id
 * @property int|null $auto_marka_id
 * @property int|null $auto_model_id
 * @property string|null $description
 * @property string|null $title
 * @property int|null $body_type_id
 * @property int|null $year
 * @property float|null $run_km
 * @property int|null $gearbox_id
 * @property float|null $engine_size
 * @property int|null $fuel_type
 * @property int|null $repair_state_id
 * @property int|null $number_owner
 * @property int|null $order
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $updated_at
 * @property int|null $updated_by
 * @property bool|null $is_deleted
 * @property int|null $deleted_by
 * @property int|null $deleted_at
 * @property int|null $reject_reason
 * @property int|null $rejected_user_id
 * @property int|null $rejected_at
 * @property int|null $neighborhood_id
 * @property int|null $region_id
 * @property int|null $district_id
 * @property int|null $auto_number
 * @property int|null $motor_hour
 * @property int|null $lifting_capacity
 * @property int|null $estimated_price
 */
class EvalueAuto extends ActiveRecord
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
        return 'evalue_auto';
    }
    public function fields()
    {
        $fields = parent::fields();
        $fields['isCanDelete'] = 'isCanDelete';
        $fields['isCanUpdate'] = 'isCanUpdate';
        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_type', 'evalue_goal_id', 'full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid', 'auto_type_id', 'auto_marka_id', 'auto_model_id', 'description',  'body_type_id', 'year', 'run_km', 'gearbox_id', 'fuel_type', 'number_owner', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['client_type', 'evalue_goal_id', 'auto_type_id', 'auto_marka_id', 'auto_model_id', 'body_type_id', 'year', 'gearbox_id', 'fuel_type', 'repair_state_id', 'number_owner', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['client_type', 'evalue_goal_id', 'auto_type_id', 'auto_marka_id', 'auto_model_id', 'body_type_id', 'year', 'gearbox_id', 'fuel_type', 'repair_state_id', 'number_owner', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['description' ,'title'], 'string'],
            [[  'run_km', 'engine_size'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['motor_hour' ,'lifting_capacity','tech_passport_seria','tech_passport_date','body_color','body_number' ,'engine_number','chassis_number'], 'safe' ],

            [['motor_hour' ,'lifting_capacity' ,'estimated_price'], 'safe' ],
            [['is_deleted'], 'default', 'value' => false],
            [[ 'reject_reason','rejected_user_id','rejected_at','neighborhood_id','region_id','district_id','auto_number'], 'safe'],
            [['full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid'], 'string', 'max' => 255],
        ];
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['statusName'] = 'statusName';
        $extraFields['hasDetail'] = 'hasDetail';
        $extraFields['locatedNearby'] = 'locatedNearby';
        $extraFields['createdBy'] = 'createdBy';
        $extraFields['repairState'] = 'repairState';
        $extraFields['evalueGoal'] = 'evalueGoal';
        $extraFields['autoImages'] = 'autoImages';
        $extraFields['texPassportFiles'] = 'texPassportFiles';
        $extraFields['rejectTypes'] = 'rejectTypes';
        $extraFields['rejectedUser'] = 'rejectedUser';
        $extraFields['autoType'] = 'autoType';
        $extraFields['autoMarka'] = 'autoMarka';
        $extraFields['autoModel'] = 'autoModel';
        $extraFields['gearbox'] = 'gearbox';
        $extraFields['bodyType'] = 'bodyType';
        $extraFields['neighborhood'] = 'neighborhood';
        $extraFields['region'] = 'region';
        $extraFields['district'] = 'district';
        $extraFields['evalueGenerate'] = 'evalueGenerate';
        $extraFields['evalueGenerates'] = 'evalueGenerates';
        $extraFields['evalueAutoResult'] = 'evalueAutoResult';
        $extraFields['autoFuelType'] = 'autoFuelType';
        $extraFields['fuelType'] = 'fuelType';
        $extraFields['fuelTypeName'] = 'fuelTypeName';
        $extraFields['passportFiles'] = 'passportFiles';
        $extraFields['autoEngineSize'] = 'autoEngineSize';
        $extraFields['engineSize'] = 'engineSize';
        $extraFields['hashId'] = function ($model) {
            return $model->hashId;
        };
        $extraFields['evalueGenerateSum'] = function() {
            return $this->evalueGenerateSum ? $this->evalueGenerateSum->sum : 0;
        };
        return $extraFields;
    }
    public function getAutoFuelType()
    {
        return $this->hasMany(AutoFuelType::className(), ['evalue_auto_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }
    public function getFuelType()
    {
        return $this->hasMany(FuelType::className(), ['id' => 'fuel_type_id'])->via('autoFuelType')->orderBy(['id' => SORT_DESC]);
    }
    public function getAutoEngineSize()
    {
        return $this->hasMany(AutoEngineSize::className(), ['evalue_auto_id' => 'id'])->orderBy(['id' => SORT_DESC]);
    }
    public function getEngineSize()
    {
        return $this->hasMany(EngineSize::className(), ['id' => 'engine_size_id'])->via('autoEngineSize')->orderBy(['id' => SORT_DESC]);
    }
    public function getEvalueGenerate()
    {
        return $this->hasOne(EvalueGenerate::className(), ['fileable_id' => 'id'])->andWhere(['fileable_type' => EvalueAuto::className()])->orderBy(['id' => SORT_DESC]);
    }
    public function getEvalueGenerateSum()
    {
        return $this->hasOne(EvalueGenerate::class, ['fileable_id' => 'id'])
            ->andWhere(['fileable_type' => self::class])
            ->select(['id', 'fileable_id', 'fileable_type', 'sum'])->orderBy(['id' => SORT_DESC]); // faqat sum!
    }

    public function getEvalueGenerates()
    {
        return $this->hasMany(EvalueGenerate::className(), ['fileable_id' => 'id'])->andWhere(['fileable_type' => EvalueAuto::className()]);
    }
    public function getEvalueAutoResult()
    {
        return $this->hasMany(EvalueAutoResult::className(), ['evalue_auto_id' => 'id'])->orderBy(['id'=>SORT_DESC])->limit(10);
    }
    public function getGearbox()
    {
        return $this->hasOne(Gearbox::className(), ['id' => 'gearbox_id']);
    }
    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::className(), ['id' => 'neighborhood_id']);
    }
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
    public function getBodyType()
    {
        return $this->hasOne(BodyType::className(), ['id' => 'body_type_id']);
    }
    public function getAutoType()
    {
        return $this->hasOne(AutoType::className(), ['id' => 'auto_type_id']);
    }
    public function getAutoMarka()
    {
        return $this->hasOne(AutoMarka::className(), ['id' => 'auto_marka_id']);
    }
    public function getAutoModel()
    {
        return $this->hasOne(AutoModel::className(), ['id' => 'auto_model_id']);
    }
    public function getEvalueGoal()
    {
        return $this->hasOne(EvalueGoal::className(), ['id' => 'evalue_goal_id']);
    }
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statusList(),$this->status);
    }
    public function getRejectTypes()
    {
        return $this->hasMany(AutoReject::className(), ['evalue_auto_id' => 'id']);
    }
    public function getRejectedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'rejected_user_id']);
    }
    public function getHashId()
    {
        return $this->id ? Yii::$app->hashidService->encode($this->id) : null;
    }
    public function getAutoImages()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_AUTO_IMAGE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getTexPassportFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_TEX_PASSPORT_FILE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getPassportFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_AUTO_PASSPORT_FILE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getAutoHasDetail()
    {
        return $this->hasMany(AutoHasDetail::className(), ['evalue_auto_id' => 'id']);
    }
    public function getHasDetail()
    {
        return $this->hasMany(HasDetail::className(), ['id' => 'has_detail_id'])->via('autoHasDetail');
    }
    public function getRepairState()
    {
        return $this->hasOne(RepairState::className(), ['id' => 'repair_state_id']);
    }
    public function getIsCanUpdate()
    {
        return $this->status == self::STATUS_NEW;
    }
    public function getIsCanDelete()
    {
        return $this->status == self::STATUS_NEW;
    }
    public function getFuelTypeName()
    {
        return  ArrayHelper::getValue([
            1=>"Benzin",
            2=>"Metan",
            3=>"Propan",
            4=>"Dizel",
            5=>"Elektr",
        ],$this->fuel_type);
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
            'auto_type_id' => 'Auto Type ID',
            'auto_marka_id' => 'Auto Marka ID',
            'auto_model_id' => 'Auto Model ID',
            'description' => 'Description',
            'body_type_id' => 'Body Type ID',
            'year' => 'Year',
            'run_km' => 'Run Km',
            'gearbox_id' => 'Gearbox ID',
            'engine_size' => 'Engine Size',
            'fuel_type' => 'Fuel Type',
            'number_owner' => 'Number Owner',
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
