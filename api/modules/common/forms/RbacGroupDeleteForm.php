<?php

namespace api\modules\common\forms;

use api\components\BaseRequest;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\RbacGroup;
use yii\base\Exception;
use yii\db\StaleObjectException;

class RbacGroupDeleteForm extends BaseRequest
{
    public RbacGroup $model;
    public function __construct(RbacGroup $model,$params = [])
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
        $this->model->is_deleted = true;
        $this->model->deleted_at = time();
        $this->model->deleted_by = \Yii::$app->user->id;
        if($this->model->save()){
            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;

    }
}
