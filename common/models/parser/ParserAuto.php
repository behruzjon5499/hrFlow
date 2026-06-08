<?php

namespace common\models\parser;

use common\models\Currency;
use Yii;

/**
 * This is the model class for table "auto_caradv".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $source
 * @property string|null $title
 * @property string $remote_identifier
 * @property string|null $mark
 * @property string|null $model
 * @property string|null $description
 * @property string|null $description_extra
 * @property string|null $expire_date
 * @property string|null $fuel
 * @property string|null $color
 * @property string|null $transm
 * @property string|null $main_photo_path
 * @property float|null $price_in_usd
 * @property float|null $price_in_UZS
 * @property int|null $car_year
 * @property string|null $contact_phone_1
 * @property string|null $contact_phone_2
 * @property string|null $path_to_adv
 * @property string|null $adv_json_list
 * @property string|null $adv_json_detail
 * @property int|null $category_id
 * @property int|null $city_id
 * @property int|null $region_id
 * @property int|null $car_model_id
 * @property int|null $dealer_id
 * @property int|null $run_km
 * @property bool $is_active
 * @property int $adv_type
 * @property string|null $car_option
 * @property float|null $motor_engine_size
 * @property int|null $owners
 * @property int|null $car_body_id
 * @property int|null $condition_id
 *
 * @property AutoCaradvphotos[] $autoCaradvphotos
 * @property AutoCarbody $carBody
 * @property AutoCarmodel $carModel
 * @property AutoCategory $category
 * @property AutoDistrict $city
 * @property AutoCondition $condition
 * @property AutoDealer $dealer
 * @property AutoRegion $region
 */
class ParserAuto extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auto_caradv';
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
        return $currency ? $currency->value * $this->price_in_usd : $this->price_in_UZS;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'mark', 'model', 'description', 'description_extra', 'expire_date', 'fuel', 'color', 'transm', 'main_photo_path', 'price_in_usd', 'price_in_UZS', 'car_year', 'contact_phone_1', 'contact_phone_2', 'path_to_adv', 'adv_json_list', 'adv_json_detail', 'category_id', 'city_id', 'region_id', 'car_model_id', 'dealer_id', 'run_km', 'car_option', 'motor_engine_size', 'owners', 'car_body_id', 'condition_id'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'source', 'remote_identifier', 'is_active', 'adv_type'], 'required'],
            [['created_at', 'updated_at', 'expire_date', 'adv_json_list', 'adv_json_detail'], 'safe'],
            [['description', 'description_extra', 'car_option'], 'string'],
            [['price_in_usd', 'price_in_UZS', 'motor_engine_size'], 'number'],
            [['car_year', 'category_id', 'city_id', 'region_id', 'car_model_id', 'dealer_id', 'run_km', 'adv_type', 'owners', 'car_body_id', 'condition_id'], 'default', 'value' => null],
            [['car_year', 'category_id', 'city_id', 'region_id', 'car_model_id', 'dealer_id', 'run_km', 'adv_type', 'owners', 'car_body_id', 'condition_id'], 'integer'],
            [['is_active'], 'boolean'],
            [['source', 'remote_identifier', 'mark', 'model', 'fuel', 'color', 'transm', 'main_photo_path', 'contact_phone_1', 'contact_phone_2', 'path_to_adv'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 200],
                ];
    }
    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['autoPhoto'] = 'autoPhoto';
        return $extraFields;
    }
    public function getAutoPhoto()
    {
        return $this->hasOne(AutoPhoto::className(), ['id' => 'adv_id']);
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
            'source' => 'Source',
            'title' => 'Title',
            'remote_identifier' => 'Remote Identifier',
            'mark' => 'Mark',
            'model' => 'Model',
            'description' => 'Description',
            'description_extra' => 'Description Extra',
            'expire_date' => 'Expire Date',
            'fuel' => 'Fuel',
            'color' => 'Color',
            'transm' => 'Transm',
            'main_photo_path' => 'Main Photo Path',
            'price_in_usd' => 'Price In Usd',
            'price_in_UZS' => 'Price In Uzs',
            'car_year' => 'Car Year',
            'contact_phone_1' => 'Contact Phone 1',
            'contact_phone_2' => 'Contact Phone 2',
            'path_to_adv' => 'Path To Adv',
            'adv_json_list' => 'Adv Json List',
            'adv_json_detail' => 'Adv Json Detail',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'region_id' => 'Region ID',
            'car_model_id' => 'Car Model ID',
            'dealer_id' => 'Dealer ID',
            'run_km' => 'Run Km',
            'is_active' => 'Is Active',
            'adv_type' => 'Adv Type',
            'car_option' => 'Car Option',
            'motor_engine_size' => 'Motor Engine Size',
            'owners' => 'Owners',
            'car_body_id' => 'Car Body ID',
            'condition_id' => 'Condition ID',
        ];
    }

    /**
     * Gets query for [[AutoCaradvphotos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutoCaradvphotos()
    {
        return $this->hasMany(AutoCaradvphotos::class, ['adv_id' => 'id']);
    }

    /**
     * Gets query for [[CarBody]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarBody()
    {
        return $this->hasOne(AutoCarbody::class, ['id' => 'car_body_id']);
    }

    /**
     * Gets query for [[CarModel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarModel()
    {
        return $this->hasOne(AutoCarmodel::class, ['id' => 'car_model_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AutoCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(AutoDistrict::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Condition]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(AutoCondition::class, ['id' => 'condition_id']);
    }

    /**
     * Gets query for [[Dealer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDealer()
    {
        return $this->hasOne(AutoDealer::class, ['id' => 'dealer_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(AutoRegion::class, ['id' => 'region_id']);
    }

}
