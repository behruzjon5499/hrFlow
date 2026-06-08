<?php

namespace common\models\parser;

use common\models\Currency;
use Yii;

/**
 * This is the model class for table "home_home".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $title
 * @property int|null $price_in_usd
 * @property int|null $price_in_uzs
 * @property int|null $price_per_unit_usd
 * @property int|null $price_per_unit_uzs
 * @property string|null $description
 * @property string|null $address_full
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $seller_full_name
 * @property string|null $seller_phone
 * @property string|null $seller_role
 * @property string|null $remote_id
 * @property string|null $source
 * @property int|null $district_id
 * @property string|null $link_to_adv
 * @property string|null $ceiling_height
 * @property int|null $floor
 * @property bool|null $has_comission
 * @property string|null $has_in_apartment
 * @property bool|null $is_furnished
 * @property float|null $kitchen_area
 * @property string|null $near_has
 * @property int|null $number_of_rooms
 * @property float|null $total_area
 * @property int|null $total_floors
 * @property float|null $total_living_area
 * @property int|null $year_of_construction_rent
 * @property int|null $bathroom_type_id
 * @property int|null $building_type_id
 * @property int|null $house_layout_id
 * @property int|null $house_type_id
 * @property int|null $repair_status_id
 * @property int|null $category_id
 * @property string|null $property_location
 * @property string|null $electricity
 * @property string|null $extra_json
 * @property string|null $gas
 * @property string|null $heating
 * @property string|null $plot
 * @property string|null $water
 * @property string|null $currentUzs
 *
 * @property HomeBathroomtype $bathroomType
 * @property HomeBuildingtype $buildingType
 * @property HomeCategory $category
 * @property HomeDistrict $district
 * @property HomeHomePropertyTypes[] $homeHomePropertyTypes
 * @property HomeHomephoto[] $homeHomephotos
 * @property HomeHouselayout $houseLayout
 * @property HomeHousetype $houseType
 * @property HomePropertytype[] $propertytypes
 * @property ParserRepairState $repairStatus
 */
class ParserHome extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'home_home';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('parser');
    }
    public function fields()
    {
        $extraFields = parent::fields();
        $extraFields['currentUzs'] ='currentUzs';
        return $extraFields;
    }
    public function getCurrentUzs()
    {
        $currency = Currency::find()->orderBy(['date'=>SORT_DESC])->one();
        return $currency ? $currency->value * $this->price_in_usd : $this->price_in_uzs;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price_in_usd', 'price_in_uzs', 'price_per_unit_usd', 'price_per_unit_uzs', 'description', 'address_full', 'latitude', 'longitude', 'seller_full_name', 'seller_phone', 'seller_role', 'remote_id', 'source', 'district_id', 'link_to_adv', 'ceiling_height', 'floor', 'has_comission', 'has_in_apartment', 'is_furnished', 'kitchen_area', 'near_has', 'number_of_rooms', 'total_area', 'total_floors', 'total_living_area', 'year_of_construction_rent', 'bathroom_type_id', 'building_type_id', 'house_layout_id', 'house_type_id', 'repair_status_id', 'category_id', 'property_location', 'electricity', 'extra_json', 'gas', 'heating', 'plot', 'water'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'title'], 'required'],
            [['created_at', 'updated_at', 'extra_json'], 'safe'],
            [['price_in_usd', 'price_in_uzs', 'price_per_unit_usd', 'price_per_unit_uzs', 'district_id', 'floor', 'number_of_rooms', 'total_floors', 'year_of_construction_rent', 'bathroom_type_id', 'building_type_id', 'house_layout_id', 'house_type_id', 'repair_status_id', 'category_id'], 'default', 'value' => null],
            [['price_in_usd', 'price_in_uzs', 'price_per_unit_usd', 'price_per_unit_uzs', 'district_id', 'floor', 'number_of_rooms', 'total_floors', 'year_of_construction_rent', 'bathroom_type_id', 'building_type_id', 'house_layout_id', 'house_type_id', 'repair_status_id', 'category_id'], 'integer'],
            [['description', 'address_full', 'ceiling_height', 'has_in_apartment', 'near_has', 'electricity', 'gas', 'heating', 'plot', 'water'], 'string'],
            [['latitude', 'longitude', 'kitchen_area', 'total_area', 'total_living_area'], 'number'],
            [['has_comission', 'is_furnished'], 'boolean'],
            [['title', 'seller_full_name', 'property_location'], 'string', 'max' => 300],
            [['seller_phone', 'seller_role', 'remote_id', 'source'], 'string', 'max' => 100],
            [['link_to_adv'], 'string', 'max' => 500],
            [['source', 'remote_id'], 'unique', 'targetAttribute' => ['source', 'remote_id']],
            ];
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['homePhoto'] = 'homePhoto';
        return $extraFields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'price_in_usd' => 'Price In Usd',
            'price_in_uzs' => 'Price In Uzs',
            'price_per_unit_usd' => 'Price Per Unit Usd',
            'price_per_unit_uzs' => 'Price Per Unit Uzs',
            'description' => 'Description',
            'address_full' => 'Address Full',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'seller_full_name' => 'Seller Full Name',
            'seller_phone' => 'Seller Phone',
            'seller_role' => 'Seller Role',
            'remote_id' => 'Remote ID',
            'source' => 'Source',
            'district_id' => 'District ID',
            'link_to_adv' => 'Link To Adv',
            'ceiling_height' => 'Ceiling Height',
            'floor' => 'Floor',
            'has_comission' => 'Has Comission',
            'has_in_apartment' => 'Has In Apartment',
            'is_furnished' => 'Is Furnished',
            'kitchen_area' => 'Kitchen Area',
            'near_has' => 'Near Has',
            'number_of_rooms' => 'Number Of Rooms',
            'total_area' => 'Total Area',
            'total_floors' => 'Total Floors',
            'total_living_area' => 'Total Living Area',
            'year_of_construction_rent' => 'Year Of Construction Rent',
            'bathroom_type_id' => 'Bathroom Type ID',
            'building_type_id' => 'Building Type ID',
            'house_layout_id' => 'House Layout ID',
            'house_type_id' => 'House Type ID',
            'repair_status_id' => 'Repair Status ID',
            'category_id' => 'Category ID',
            'property_location' => 'Property Location',
            'electricity' => 'Electricity',
            'extra_json' => 'Extra Json',
            'gas' => 'Gas',
            'heating' => 'Heating',
            'plot' => 'Plot',
            'water' => 'Water',
        ];
    }

    /**
     * Gets query for [[BathroomType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBathroomType()
    {
        return $this->hasOne(HomeBathroomtype::class, ['id' => 'bathroom_type_id']);
    }

    /**
     * Gets query for [[BuildingType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBuildingType()
    {
        return $this->hasOne(HomeBuildingtype::class, ['id' => 'building_type_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(HomeCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(HomeDistrict::class, ['id' => 'district_id']);
    }

    /**
     * Gets query for [[HomeHomePropertyTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomeHomePropertyTypes()
    {
        return $this->hasMany(HomeHomePropertyTypes::class, ['home_id' => 'id']);
    }

    /**
     * Gets query for [[HomeHomephotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHomePhoto()
    {
        return $this->hasOne(HomePhoto::class, ['home_id' => 'id'])->orderBy(['id'=>SORT_ASC]);
    }

    /**
     * Gets query for [[HouseLayout]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHouseLayout()
    {
        return $this->hasOne(HomeHouselayout::class, ['id' => 'house_layout_id']);
    }

    /**
     * Gets query for [[HouseType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHouseType()
    {
        return $this->hasOne(HomeHousetype::class, ['id' => 'house_type_id']);
    }

    /**
     * Gets query for [[Propertytypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropertytypes()
    {
        return $this->hasMany(HomePropertytype::class, ['id' => 'propertytype_id'])->viaTable('home_home_property_types', ['home_id' => 'id']);
    }

    /**
     * Gets query for [[RepairStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRepairStatus()
    {
        return $this->hasOne(ParserRepairState::class, ['id' => 'repair_status_id']);
    }

}
