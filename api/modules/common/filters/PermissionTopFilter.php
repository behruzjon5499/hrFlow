<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;
use backend\modules\rbac\models\RbacAuthItem;
use common\enums\RoleEnum;
use common\models\AuthItem;

class PermissionTopFilter extends BaseRequest
{

    public function getResult()
    {
        return  RoleEnum::ACTIONS;
    }
}