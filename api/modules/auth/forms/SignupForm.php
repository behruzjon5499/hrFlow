<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use backend\modules\rbac\models\RbacAuthAssignment;
use common\enums\UserEnum;
use common\models\User;
use common\models\UserProfile;
use Exception;
use Yii;

class SignupForm extends BaseRequest
{
    public $full_name;
    public $email;
    public $gender;
    public $phone;
    public $birthday;
    public $passport;
    public $password;
    public $pnfl;
    public $address;
    public $position;
    public $mfo;
    public $roles;

    public function rules()
    {
        return [
            [['phone', 'email'], 'checkUnique'],
            [
                [
                    'full_name',
                    'phone',
                    'password',
                    'phone',
                    'birthday',
                    'address',
                    'passport',
                    'position',
                    'mfo',
                    'pnfl',
                    'pnfl',
                ],
                'required', 'message' => t('{attribute} yuborish majburiy')
            ],
            [
                [
                    'address',
                    'email',
                    'roles',

                ],
                'safe', 'message' => t('{attribute} yuborish majburiy')
            ],
        ];
    }
    public function checkUnique()
    {
        $user = User::findOne(['username'=>$this->phone]);
        if ($user){
            throw new \yii\base\Exception("This phone already exist");
        }
    }

    public function getResult()
    {
        try {

            $transaction = Yii::$app->db->beginTransaction();
            $user = new User();
            $user->username = $this->phone;
            $user->email = $this->email;
            $user->generateAuthKey();
            $user->setPassword($this->password);
            $user->status = UserEnum::STATUS_ACTIVE;

            if ( !$user->save(false)) {
                $transaction->rollBack();
                throw new Exception('User save error');
            }
            $profile = new UserProfile();
            $profile->user_id = $user->id;
            $profile->full_name = $this->full_name;
            $profile->locale = 'uz';
            $profile->gender = $this->gender;
            $profile->birthday = $this->birthday;
            $profile->mfo = $this->mfo;
            $profile->position = $this->position;
            $profile->address = $this->address;
            $profile->pnfl = $this->pnfl;
            $profile->passport = $this->passport;
            if (!$profile->save(false)) {
                $transaction->rollBack();
                throw new Exception('User Profile save error');
            }
            if (count($this->roles)>0){
                foreach ($this->roles as $role) {
                    $roleModel = new RbacAuthAssignment();
                    $roleModel->item_name = $role;
                    $roleModel->user_id = $user->id;
                    $roleModel->created_at = time();
                    if (!$roleModel->save()) {
                        $transaction->rollBack();
                        throw new Exception('ROLE save error');
                    }
                }
            }
            $transaction->commit();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function getAccessToken()
    {
        $access_token = Yii::$app->security->generateRandomString(40);
        $this->user->access_token = $access_token;
        if (!$this->user->save(false)) {
            throw new Exception('User access token save error');
        }
        return $access_token;
    }

}
