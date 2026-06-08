<?php

use common\enums\RoleEnum;
use common\models\User;
use common\rbac\Migration;

class m150625_214101_roles extends Migration
{
    /**
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->auth->removeAll();

        $user = $this->auth->createRole(RoleEnum::ROLE_USER);
        $this->auth->add($user);

        $editor = $this->auth->createRole(RoleEnum::ROLE_EDITOR);
        $this->auth->add($editor);
        //$this->auth->addChild($editor, $user);

        $commission = $this->auth->createRole(RoleEnum::ROLE_COMMISSION);
        $this->auth->add($commission);

        $admin = $this->auth->createRole(RoleEnum::ROLE_ADMINISTRATOR);
        $this->auth->add($admin);
//        $this->auth->addChild($admin, $editor);
//        $this->auth->addChild($admin, $user);

        $this->auth->assign($admin, 1);
        $this->auth->assign($editor, 2);
        $this->auth->assign($user, 3); // klent, korxona
        $this->auth->assign($commission, 4);
        $this->auth->assign($commission, 5);
        $this->auth->assign($commission, 6);
        $this->auth->assign($commission, 7);
        $this->auth->assign($commission, 8);
        $this->auth->assign($commission, 9);//rais
        $this->auth->assign($commission, 10);//sekretar
        $this->auth->assign($user, 11);//company
        $this->auth->assign($user, 12);//company
        $this->auth->assign($user, 13);//company
    }

    /**
     * @return bool|void
     */
    public function down()
    {
        $this->auth->remove($this->auth->getRole(RoleEnum::ROLE_ADMINISTRATOR));
        $this->auth->remove($this->auth->getRole(RoleEnum::ROLE_EDITOR));
        $this->auth->remove($this->auth->getRole(RoleEnum::ROLE_USER));
        $this->auth->remove($this->auth->getRole(RoleEnum::ROLE_COMMISSION));
    }
}
