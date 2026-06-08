<?php

namespace api\modules\auth\forms;

use api\modules\client\services\SmsService;
use common\models\User;
use common\models\UserCode;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 *  SetPasswordForm form
 */
class SetPasswordForm extends Model
{

    public $phone;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'required', 'message' => t('{attribute} yuborish majburiy')],
            ['password', 'required', 'message' => t('{attribute} yuborish majburiy')],

        ];
    }
    public function getResult()
    {
        try {
            $user = User::findOne(['username'=>$this->phone]);
            if (!$user) {
                throw new Exception('User not found');
            }
            $user->generateAuthKey();
            $user->setPassword($this->password);
            if ($user->save(false)){
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
