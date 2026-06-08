<?php

namespace api\modules\auth\forms;

use api\components\BaseRequest;
use api\modules\auth\resources\UserResource;
use backend\modules\rbac\models\RbacAuthAssignment;
use common\enums\CompanyEnum;
use common\enums\RoleEnum;
use common\enums\UserEnum;
use common\models\Bank;
use common\models\BlackList;
use common\models\Company;
use common\models\CompanyBalance;
use common\models\CompanyBankAccount;
use common\models\Region;
use Exception;
use Yii;

class SignupNoResidentForm extends BaseRequest
{
    public $country_id;
    public $company_name;
    public $account_number;
    public $tin;
    public $swift;
    public $currency;
    public $director_fullname;
    public $passport;
    public $passport_valid_date;
    public $email;
    public $address;
    public $password;
    public $confirmPassword;
    public $offer_agreement;

    public function rules()
    {
        return [
            [
                [
                    'country_id',
                    'company_name',
                    'account_number',
                    'tin',
                    'swift',
                    'currency',
                    'director_fullname',
                    'passport',
                    'passport_valid_date',
                    'email',
                    'address',
                    'password',
                    'confirmPassword',
                    'offer_agreement',
                ],
                'required', 'message' => t('{attribute} yuborish majburiy')
            ],
            [
                [
                    'country_id',
                    'company_name',
                    'account_number',
                    'tin',
                    'swift',
                    'currency',
                    'director_fullname',
                    'passport',
                    'passport_valid_date',
                    'email',
                    'address',
                    'password',
                    'confirmPassword',
                    'offer_agreement',
                ],
                'trim',
            ],
            [
                [
                    'company_name',
                    'account_number',
                    'tin',
                    'swift',
                    'director_fullname',
                    'passport',
//                    'passport_valid_date',
                    'email',
                    'address',
                    'password',
                    'confirmPassword',
//                    'offer_agreement',
                ],
                'string',
            ],
            [
                [
                    'country_id',
                    'currency',
                    'offer_agreement',
                ],
                'integer',
            ],
            [
                ['country_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Region::class,
                'targetAttribute' => ['country_id' => 'id'],
            ],
            [
                ['email'],
                'email',
            ],
            [
                ['email'],
                'unique',
                'targetClass' => UserResource::class,
                'message' => Yii::t('main', 'Bu elektron pochta, tizimda band qilingan'),
            ],
            [
                ['tin'],
                'unique',
                'targetClass' => Company::class,
                'message' => Yii::t('main', 'Bu STIR, tizimda band qilingan'),
            ],
            // [
            //   ['phone'],
            //   'unique',
            //   'targetClass' => UserResource::class,
            //   'message' => Yii::t('api', 'This phone number has already been taken'),
            // ],
            [
                ['password'],
                'string',
                'min' => 6,
            ],
            [
                ['password'],
                'compare',
                'compareAttribute' => 'confirmPassword',
            ],
            [
                ['offer_agreement'],
                'boolean',
            ],
            [
                ['offer_agreement'],
                'compare',
                'compareValue' => true,
                'message' => Yii::t('api', 'You must accept the offer agreement'),
            ],
        ];
    }

    public function getResult()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();

            $company = Company::find()->where(['tin' => $this->tin])->one();
            if ($company) {
                throw new Exception("Bu korxona avval ro'yxatdan o'tgan");
            }

            if(BlackList::find()->where(['inn' => $this->tin])->exists()){
                throw new Exception(Yii::t('main', "Tizimga kirish mumkin emas (insofsiz ijrochi)"));
            }

            $company = new Company();
            $company->resident = CompanyEnum::NO_RESIDENT;
            $company->title = $this->company_name;
            $company->tin = $this->tin;
            $company->address = $this->address;
            $company->pinfl = $this->tin;
            $company->status = CompanyEnum::STATUS_ACTIVE;
            $company->country_id = $this->country_id;
            $company->director = $this->director_fullname;
            $company->passport = $this->passport;
            $company->passport_valid_date = date("Y-m-d", strtotime($this->passport_valid_date));

            if (!$company->save(false)) {
                $transaction->rollBack();
                throw new Exception('Company save error');
            }

            $account = new CompanyBankAccount();
            $account->company_id = $company->id;
            $account->swift = $this->swift;
            $account->account = $this->account_number;
            $account->mfo = "00001";
            $account->is_main = 1;
            $account->created_at = date("Y-m-d H:i:s");
            if (!$account->save(false)) {
                $transaction->rollBack();
                throw new Exception('Company save error');
            }

            $balance = new CompanyBalance();
            $balance->company_id = $company->id;
            $balance->available = 0;
            $balance->balance = 0;
            $balance->blocked = 0;
            if (!$balance->save(false)) {
                $transaction->rollBack();
                throw new Exception('Company balance save error');
            }


            $user = new UserResource();
            $user->username = $company->tin;
            $user->email = $this->email;
            $user->generateAuthKey();
            // TODO: phone column is not exists in user table
            // $user->phone = $this->phone;
            $user->setPassword($this->password);
            $user->status = UserEnum::STATUS_NOT_ACTIVE;
            $user->company_id = $company->id;

            if (!$user->save(false)) {
                $transaction->rollBack();
                throw new Exception('User save error');
            }

            $role = new RbacAuthAssignment();
            $role->item_name = RoleEnum::ROLE_USER;
            $role->user_id = (string)$user->id;
            $role->created_at = time();
            if (!$role->save()) {
                $transaction->rollBack();
                throw new Exception('ROLE save error');
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
