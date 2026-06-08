<?php

namespace api\modules\common\forms;

use api\components\BaseRequest;

use backend\modules\rbac\models\RbacAuthItem;
use common\models\AuthItem;
use common\models\AuthItemChild;
use Yii;

class AuthItemCreateForm extends BaseRequest
{

    public $name;
    public $type;
    public $order;
    public $description;
    public $pages = [];

    public AuthItem $model;
    public function __construct(AuthItem $model,$params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }

    public function rules()
    {
        return [
            [[ 'name','pages'], 'required', 'message' => t('{attribute} yuborish majburiy')],
            [['description','type','order' ], 'safe', 'message' => t('{attribute} yuborish majburiy')],

        ];
    }

    public function getResult()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $att = $this->attributes;
        $this->model->setAttributes($att,false);
        $this->model->created_at = time();
        $this->model->updated_at = time();
        $this->model->type = AuthItem::TYPE_ROLE;
        $this->model->description = $this->name;
        if ($this->model->attributes && $this->model->validate() && $this->model->save()) {
            if (count($this->pages) > 0) {
                foreach ($this->pages as $permission) {
                    foreach ($permission as $key => $actions) {
                        foreach ($actions as $action) {
                            if (is_array($action)) {
                                foreach ($action as $c) {
                                    $name = $key . "-" . $c['name'];
                                    $oldModel = AuthItem::findOne(['name' => $name]);
                                    $model = $oldModel ?? new AuthItem();
                                    $model->name = $name;
                                    $model->type = AuthItem::TYPE_PERMISSION;
                                    if ($model->save() && $c['value']) {
                                        $childItem = new AuthItemChild();
                                        $childItem->parent = $this->model->name;
                                        $childItem->child = $name;
                                        $childItem->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;

    }
}
