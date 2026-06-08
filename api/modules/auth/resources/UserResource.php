<?php

namespace api\modules\auth\resources;

use backend\modules\rbac\models\RbacAuthAssignment;
use backend\modules\rbac\models\RbacAuthItemChild;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserResource extends \common\models\User
{

    public function extraFields()
    {
        return [
            'userProfile',
            'roles',
            'permissions',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfileResource::class, ['user_id' => 'id']);
    }

    public function getRoles()
    {
        return ArrayHelper::getColumn(RbacAuthAssignment::find()->andWhere(['user_id'=>$this->id])->all(),'item_name');
    }
    public function getPermissions()
    {
        return ArrayHelper::getColumn(RbacAuthItemChild::find()->andWhere(['in','parent',$this->roles])->all(),'child');
    }
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
