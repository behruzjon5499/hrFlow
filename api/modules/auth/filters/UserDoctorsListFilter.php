<?php


namespace api\modules\auth\filters;


use api\components\BaseRequest;
use api\modules\auth\resources\UserResource;
use common\enums\RoleEnum;
use common\models\User;

class UserDoctorsListFilter extends BaseRequest
{
    public $search;
    public $service_id;
    public $role;

    public function rules()
    {
        return [
            [['search', 'service_id', 'role'], 'safe'],
        ];
    }

    public function getResult()
    {
        $model = UserResource::find()->select([
            'id',
            'status',
            'user_profile.full_name',
        ]);
        $model->leftJoin('rbac_auth_assignment', 'rbac_auth_assignment.user_id="user".id');
        $model->leftJoin('user_profile', 'user_profile.user_id="user".id');
        $model->andWhere(['in', 'rbac_auth_assignment.item_name', RoleEnum::ALL_DOCTOR_ROLES]);

        return $model->asArray()->all();
    }
}
