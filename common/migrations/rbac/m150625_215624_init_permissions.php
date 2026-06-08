<?php

use common\enums\RoleEnum;
use common\models\User;
use common\rbac\Migration;

class m150625_215624_init_permissions extends Migration
{
    public function up()
    {
        $editorRole = $this->auth->getRole(RoleEnum::ROLE_EDITOR);
        $administratorRole = $this->auth->getRole(RoleEnum::ROLE_ADMINISTRATOR);

        $loginToBackend = $this->auth->createPermission('login_to_backend');
        $this->auth->add($loginToBackend);

        $this->auth->addChild($editorRole, $loginToBackend);
        $this->auth->addChild($administratorRole, $loginToBackend);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getPermission('login_to_backend'));
    }
}
