<?php

namespace common\models;

use api\modules\client\helpers\EvalueContsans;
use api\modules\client\helpers\EvalueHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "full_data_view_dashboard_by_status".
 *
 * @property int|null $id
 * @property string|null $src
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $title
 * @property string|null $full_name
 * @property string|null $type
 * @property string|null $statusname
 */
class FullDataViewDashboardByStatus extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'full_data_view_dashboard_by_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'src', 'status', 'created_at', 'title', 'full_name', 'type', 'statusname'], 'default', 'value' => null],
            [['id', 'status'], 'default', 'value' => null],
            [['id', 'status'], 'integer'],
            [['src', 'type', 'statusname'], 'string'],
            [['created_at'], 'safe'],
            [['title', 'full_name'], 'string', 'max' => 255],
        ];
    }
    public function fields()
    {
        $fields = parent::fields();

        $fields['statusName'] = function () {
            return ArrayHelper::getValue(EvalueHelper::getStatusName(),$this->status);
        };

        return $fields;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'src' => 'Src',
            'status' => 'Status',
            'created_at' => 'Created At',
            'title' => 'Title',
            'full_name' => 'Full Name',
            'type' => 'Type',
            'statusname' => 'Statusname',
        ];
    }
    public static function primaryKey()
    {
        return ['id']; // yoki ['evalue_id'] — viewingizdagi real unique ustun
    }
}
