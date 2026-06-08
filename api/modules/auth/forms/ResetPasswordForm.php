<?php

namespace api\modules\auth\forms;

use api\modules\client\services\SmsService;
use common\models\User;
use common\models\UserCode;
use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    /**
     * @var
     */
    public $phone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone', 'required', 'message' => t('{attribute} yuborish majburiy')],
            ['phone', 'string', 'min' => 6],
        ];
    }
    public function getResult()
    {
        try {
            $user = User::findOne(['username'=>$this->phone]);
            if (!$user) {
                throw new Exception('User not found');
            }
            $userCode = new  UserCode();
            $userCode->user_id = $user->id;
            $userCode->code = strval(rand(10000, 99999));
            $userCode->expired_at = time()+60;
            if (!$userCode->save()){
                dd($userCode->getErrors());
            }
            $message = 'Код для восстановления пароля на сайте evalue.uz: '.$userCode->code;
            $smsService  = Yii::$container->get(SmsService::class);
            $smsService->sendSms($user->username,$message);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
