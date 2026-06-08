<?php

namespace common\models;

use api\modules\common\resources\FileResource;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "evalue_home".
 *
 * @property int $id
 * @property int|null $client_type
 * @property int|null $evalue_goal_id
 * @property string|null $full_name
 * @property string|null $client_phone
 * @property string|null $bank_phone
 * @property string|null $passport
 * @property string|null $client_uid
 * @property string|null $cadastre_number
 * @property int|null $property_type
 * @property int|null $home_type_id
 * @property string|null $description
 * @property int|null $region_id
 * @property int|null $district_id
 * @property string|null $address
 * @property string|null $longitude
 * @property string|null $latitude
 * @property int|null $room_count
 * @property float|null $total_area
 * @property float|null $living_area
 * @property int|null $building_material_id
 * @property int|null $repair_state_id
 * @property int|null $home_plan_id
 * @property int|null $floor
 * @property int|null $home_floor
 * @property int|null $bathroom_type
 * @property int|null $building_year
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
 * @property int|null $has_ownership
 * @property int|null $neighborhood_id
 * @property int|null $usable_area
 * @property int|null $completion_percent
 * @property int|null $facade_id
 * @property int|null $estimated_price
 * @property int|null $home_sub_type_id
 * @property int|null $appraised_building_part
 */
class EvalueHome extends  ActiveRecord
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
        return 'evalue_home';
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
            [['client_type', 'evalue_goal_id', 'full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid', 'cadastre_number', 'property_type', 'home_type_id', 'description', 'region_id', 'district_id', 'address', 'longitude', 'latitude', 'room_count', 'total_area', 'living_area', 'building_material_id', 'repair_state_id', 'home_plan_id', 'floor', 'home_floor', 'bathroom_type', 'building_year', 'order', 'created_at', 'created_by', 'updated_at', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['is_deleted'], 'default', 'value' => false],
            [['client_type', 'evalue_goal_id', 'property_type', 'home_type_id', 'region_id', 'district_id', 'room_count', 'building_material_id', 'repair_state_id', 'home_plan_id', 'floor', 'home_floor', 'bathroom_type', 'building_year', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'default', 'value' => null],
            [['client_type', 'evalue_goal_id', 'property_type', 'home_type_id', 'region_id', 'district_id', 'room_count', 'building_material_id', 'repair_state_id', 'home_plan_id', 'floor', 'home_floor', 'bathroom_type', 'building_year', 'order', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'], 'integer'],
            [['description', 'address','title'], 'string'],
            [['total_area', 'living_area'], 'number'],
            [['is_deleted','has_ownership'], 'boolean'],
            [['company_name','passport','location_type' ,'land_area','ownership_right','estimated_price','appraised_building_part'], 'safe' ],
            [['rejected_at','rejected_user_id','reject_reason','neighborhood_id','usable_area','completion_percent','facade_id','home_sub_type_id'], 'safe'],
            [['full_name', 'client_phone', 'bank_phone', 'passport', 'client_uid', 'cadastre_number', 'longitude', 'latitude'], 'string', 'max' => 255],
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
        $extraFields['buildingMaterial'] = 'buildingMaterial';
        $extraFields['evalueGoal'] = 'evalueGoal';
        $extraFields['region'] = 'region';
        $extraFields['district'] = 'district';
        $extraFields['homePlan'] = 'homePlan';
        $extraFields['homeImages'] = 'homeImages';
        $extraFields['cadastreFiles'] = 'cadastreFiles';
        $extraFields['rejectTypes'] = 'rejectTypes';
        $extraFields['rejectedUser'] = 'rejectedUser';
        $extraFields['facade'] = 'facade';
        $extraFields['neighborhood'] = 'neighborhood';
        $extraFields['communication'] = 'communication';
        $extraFields['evalueGenerate'] = 'evalueGenerate';
        $extraFields['evalueGenerates'] = 'evalueGenerates';
        $extraFields['homeType'] = 'homeType';
        $extraFields['evalueHomeResult'] = 'evalueHomeResult';
        $extraFields['passportFiles'] = 'passportFiles';
        $extraFields['homeSubType'] = 'homeSubType';
        $extraFields['propertyType'] = 'propertyType';
        $extraFields['evalueHomeFloor'] = 'evalueHomeFloor';
        $extraFields['ownershipRightName'] = 'ownershipRightName';
        $extraFields['hashId'] = function ($model) {
            return $model->hashId;
        };
        $extraFields['evalueGenerateSum'] = function() {
            return $this->evalueGenerateSum ? $this->evalueGenerateSum->sum : 0;
        };
        return $extraFields;
    }
    public function getEvalueHomeResult()
    {
        return $this->hasMany(EvalueHomeResult::className(), ['evalue_home_id' => 'id'])->orderBy(['id'=>SORT_DESC]);
    }
    public function getEvalueHomeFloor()
    {
        return $this->hasMany(EvalueHomeFloor::className(), ['evalue_home_id' => 'id']);
    }
    public function getHomeType()
    {
        return $this->hasOne(HomeType::className(), ['id' => 'home_type_id']);
    }
    public function getPropertyType()
    {
        return $this->hasOne(HomePropertyType::className(), ['id' => 'property_type']);
    }
    public function getHomeSubType()
    {
        return $this->hasOne(HomeSubType::className(), ['id' => 'home_sub_type_id']);
    }
    public function getEvalueGoal()
    {
        return $this->hasOne(EvalueGoal::className(), ['id' => 'evalue_goal_id']);
    }
    public function getEvalueGenerate()
    {
        return $this->hasOne(EvalueGenerate::className(), ['fileable_id' => 'id'])->andWhere(['fileable_type' => EvalueHome::className()])->orderBy(['id' => SORT_DESC]);
    }
    public function getEvalueGenerates()
    {
        return $this->hasMany(EvalueGenerate::className(), ['fileable_id' => 'id'])->andWhere(['fileable_type' => EvalueHome::className()]);
    }
    public function getEvalueGenerateSum()
    {
        return $this->hasOne(EvalueGenerate::class, ['fileable_id' => 'id'])
            ->andWhere(['fileable_type' => self::class])
            ->select(['id', 'fileable_id', 'fileable_type', 'sum'])->orderBy(['id' => SORT_DESC]); // faqat sum!
    }
    public function getFacade()
    {
        return $this->hasOne(Facade::className(), ['id' => 'facade_id']);
    }
    public function getHashId()
    {
        return $this->id ? Yii::$app->hashidService->encode($this->id) : null;
    }
    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::className(), ['id' => 'neighborhood_id']);
    }
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::statusList(),$this->status);
    }
    public function getRejectTypes()
    {
        return $this->hasMany(HomeReject::className(), ['evalue_home_id' => 'id']);
    }
    public function getRejectedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'rejected_user_id']);
    }
    public function getHomePlan()
    {
        return $this->hasOne(HomePlan::className(), ['id' => 'home_plan_id']);
    }
    public function getHomeImages()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_IMAGE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getCadastreFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_CADASTRE_FILE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getPassportFiles()
    {
        return $this->hasMany(FileResource::className(), ['fileable_id' => 'id'])->andWhere(['type'=>File::TYPE_PASSPORT_FILE])->andWhere(['fileable_type'=>get_class($this)]);
    }
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }
    public function getRepairState()
    {
        return $this->hasOne(RepairState::className(), ['id' => 'repair_state_id']);
    }
    public function getBuildingMaterial()
    {
        return $this->hasOne(BuildingMaterial::className(), ['id' => 'building_material_id']);
    }
    public function getHomeHasDetail()
    {
        return $this->hasMany(HomeHasDetail::className(), ['evalue_home_id' => 'id']);
    }
    public function getHasDetail()
    {
        return $this->hasMany(HasDetail::className(), ['id' => 'has_detail_id'])->via('homeHasDetail');
    }
    public function getHomeCommunication()
    {
        return $this->hasMany(HomeCommunication::className(), ['evalue_home_id' => 'id']);
    }
    public function getCommunication()
    {
        return $this->hasMany(Communication::className(), ['id' => 'communication_id'])->via('homeCommunication');
    }
    public function getHomeLocatedNearby()
    {
        return $this->hasMany(HomeLocatedNearby::className(), ['evalue_home_id' => 'id']);
    }
    public function getLocatedNearby()
    {
        return $this->hasMany(LocatedNearby::className(), ['id' => 'located_nearby_id'])->via('homeLocatedNearby');
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
            'cadastre_number' => 'Cadastre Number',
            'property_type' => 'Property Type',
            'home_type_id' => 'Home Type',
            'description' => 'Description',
            'region_id' => 'Region ID',
            'district_id' => 'District ID',
            'address' => 'Address',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'room_count' => 'Room Count',
            'total_area' => 'Total Area',
            'living_area' => 'Living Area',
            'building_material_id' => 'Building Material ID',
            'repair_state_id' => 'Repair State ID',
            'home_plan_id' => 'Home Plan ID',
            'floor' => 'Floor',
            'home_floor' => 'Home Floor',
            'bathroom_type' => 'Bathroom Type',
            'building_year' => 'Building Year',
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
    public function getOwnershipRightName()
    {
        return ArrayHelper::getValue([
            1=>"To'liq egalik huquqi",
            2=>"Qismiy egalik huquqi",
            3=>"Ijara",
            4=>"Boshqa",
        ],$this->ownership_right);
    }
}
