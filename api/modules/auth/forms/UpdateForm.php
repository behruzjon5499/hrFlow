<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use common\models\User;
use Exception;
use Yii;

class UpdateForm extends BaseRequest
{
    public $email;

    public $username;
    public $password;


    public function rules()
    {
        return [
            [
                [
                    'email',
                    'username',
                ],
                'required',
            ],
            [
                [
                    'password',
                ],
                'safe',
            ],
        ];
    }

    public function getResult()
    {
        try {
            $user = User::findOne(Yii::$app->user->id);
            $transaction = Yii::$app->db->beginTransaction();

            $user->email = $this->email;
            $user->username = $this->username;
            if ($this->password != null) {
                $user->setPassword($this->password);
            }
            if (!$user->save(false)) {
                $transaction->rollBack();
                throw new Exception('User save error');
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
