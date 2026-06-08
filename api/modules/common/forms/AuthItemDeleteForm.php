<?php

namespace api\modules\common\forms;

use api\components\BaseRequest;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\AuthItem;
use Yii;
use yii\base\Exception;
use yii\db\StaleObjectException;

class AuthItemDeleteForm extends BaseRequest
{
    public AuthItem $model;
    public function __construct( AuthItem $model,$params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }


    /**
     * @throws \yii\db\Exception
     * @throws \Throwable
     * @throws Exception
     * @throws StaleObjectException
     */
    public function getResult()
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $auth = Yii::$app->authManager;
        $admin = $auth->getRole($this->model->name);
        $auth->removeChildren($admin);
        if($this->model->delete()){
            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;

    }
}
