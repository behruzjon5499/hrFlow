<?php

namespace api\modules\common\forms;

use api\components\BaseRequest;

use backend\modules\rbac\models\RbacAuthItem;
use common\models\AuthItem;
use common\models\AuthItemChild;
use Yii;

class AuthItemUpdateForm extends BaseRequest
{

    public $name;
    public $type;
    public $order;
    public $description;
    public $pages = [];

    public AuthItem $model;

    public function __construct(AuthItem $model, $params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }

    public function rules()
    {
        return [
            [['description', 'type', 'name', 'pages','order'], 'required', 'message' => t('{attribute} yuborish majburiy')],

        ];
    }

    public function getResult()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $att = $this->attributes;
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole($this->model->name);
        $auth->removeChildren($admin);
//        $auth->removeAllPermissions($admin);
        $this->model->setAttributes($att, false);
        $this->model->type = AuthItem::TYPE_ROLE;
        $this->model->description = $this->name;
        $this->model->updated_at = time();
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
