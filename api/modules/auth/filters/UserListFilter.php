<?php


namespace api\modules\auth\filters;


use api\components\BaseRequest;
use api\modules\auth\resources\UserResource;
use common\enums\RoleEnum;
use common\models\Services;
use common\models\User;

class UserListFilter extends BaseRequest
{
    public $search;
    public $service_id;
    public $role;

    public function rules()
    {
        return [
            [['search','service_id','role'], 'safe'],
        ];
    }

    public function getResult()
    {

        $model = UserResource::find();
        if ($this->search){
            $model->leftJoin('user_profile','user_profile.user_id="user".id');

            $model->andWhere(['OR',
                ['ilike','user.username',$this->search],
                ['ilike','user_profile.full_name',$this->search],
                ['ilike','user_profile.phone',$this->search],
            ]);
        }
        if ($this->service_id){
            $service = Services::findOne($this->service_id);
            if ($service){
                $model->leftJoin('user_service','user_service.user_id="user".id');
                $model->andWhere(['OR',['user_service.service_id'=>$service->parent_id],['user_service.service_id'=>$this->service_id]]);
            }
        }
        if ($this->role){
            $model->leftJoin('rbac_auth_assignment','rbac_auth_assignment.user_id="user".id');
            if($this->role=='allDoctor'){
                $model->andWhere(['in','rbac_auth_assignment.item_name',RoleEnum::ALL_DOCTOR_ROLES]);
            }
            else{
                $model->andWhere(['LIKE','rbac_auth_assignment.item_name',$this->role]);
            }

        }
        return paginate($model,50);
    }
}
