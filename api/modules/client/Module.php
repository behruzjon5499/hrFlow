<?php

namespace api\modules\client;

use api\components\ApiUserIdentity;
use api\components\BaseApiModule;

class Module extends BaseApiModule
{
    public function identityClass(): string
    {
        return ApiUserIdentity::class;
    }
}
