<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\User;
use common\models\UserProfile;
use yii\base\Exception;
use yii\db\StaleObjectException;

class DeleteUserForm extends BaseRequest
{
    public User $model;
    public function __construct(User $model,$params = [])
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

        if($this->model->delete()){
            UserProfile::deleteAll(['user_id'=>$this->model->id]);
            RbacAuthAssignment::deleteAll(['user_id'=>$this->model->id]);
            $transaction->commit();
            return true;
        }
        $transaction->rollBack();
        $this->addErrors($this->model->errors);
        return false;

    }
}
