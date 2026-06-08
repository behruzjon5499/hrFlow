<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use common\models\User;
use common\models\UserCode;
use yii\base\Exception;

/**
 * Password reset form
 */
class PasswordConfirmForm extends BaseRequest
{
    public $phone;
    public $code;

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [
                [
                    'phone',
                    'code',
                ],
                'required', 'message' => t('{attribute} yuborish majburiy')
            ],
        ];
    }

    public function getResult()
    {
        try {
            $user = User::findOne(['username' => $this->phone]);
            if (!$user) {
                throw new Exception('User not found');
            }
            $userCode = UserCode::find()->andWhere(['user_id' => $user->id])->andWhere(['code' => $this->code])->one();

            if (!$userCode) {
                throw new Exception("Wrong password");
            }
            if ($userCode->expired_at < time()) {
                throw new Exception("Code expired");
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
