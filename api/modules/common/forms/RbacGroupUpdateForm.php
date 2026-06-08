<?php

namespace api\modules\common\forms;

use api\components\BaseRequest;

use backend\modules\rbac\models\RbacAuthItem;
use common\models\RbacGroup;
use Yii;

class RbacGroupUpdateForm extends BaseRequest
{

    public $title;
    public $description;
    public $order;

    public RbacGroup $model;
    public function __construct(RbacGroup $model,$params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }

    public function rules()
    {
        return [
            [['description','title','order'], 'required', 'message' => t('{attribute} yuborish majburiy')],

        ];
    }

    public function getResult()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $att = $this->attributes;
        $this->model->setAttributes($att,false);
        if($this->model->attributes && $this->model->validate() && $this->model->save()){
            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;

    }
}
