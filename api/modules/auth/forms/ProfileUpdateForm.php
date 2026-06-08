<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use backend\modules\rbac\models\RbacAuthAssignment;
use common\enums\UserEnum;
use common\models\User;
use Exception;
use Yii;

class ProfileUpdateForm extends BaseRequest
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
    public User $model;

    public function __construct(User $model, $params = [])
    {
        $this->model = $model;
        parent::__construct($params);
    }
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
                    'position',
                    'mfo',
                    'passport',
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
        if ($user->id != $this->model->id){
            throw new \yii\base\Exception("This phone already exist");
        }
    }
    public function getResult()
    {
        try {

            $transaction = Yii::$app->db->beginTransaction();

            $this->model->username = $this->phone;
            $this->model->email = $this->email;
            $this->model->generateAuthKey();
            $this->model->setPassword($this->password);
            $this->model->status = UserEnum::STATUS_ACTIVE;

            if ( ! $this->model->save(false)) {
                $transaction->rollBack();
                throw new Exception('User save error');
            }
            $profile =  $this->model->userProfile;
            $profile->user_id =  $this->model->id;
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
                RbacAuthAssignment::deleteAll(['user_id'=> $this->model->id]);
                foreach ($this->roles as $role) {
                    $roleModel = new RbacAuthAssignment();
                    $roleModel->item_name = $role;
                    $roleModel->user_id =  $this->model->id;
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
