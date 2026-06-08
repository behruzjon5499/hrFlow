<?php

namespace api\modules\auth\controllers;

use api\components\ApiController;
use api\modules\auth\filters\UserDoctorsListFilter;
use api\modules\auth\filters\UserListFilter;
use api\modules\auth\forms\DeleteUserForm;
use api\modules\auth\forms\LoginForm;
use api\modules\auth\forms\PasswordConfirmForm;
use api\modules\auth\forms\ProfileUpdateForm;
use api\modules\auth\forms\ResetPasswordForm;
use api\modules\auth\forms\SetPasswordForm;
use api\modules\auth\forms\SetUserAvatarForm;
use api\modules\auth\forms\SignupForm;
use api\modules\auth\resources\UserResource;
use api\modules\common\resources\FileResource;
use Yii;

class UserController extends ApiController
{

    public function actionLogin()
    {
        return $this->sendResponse(
            new LoginForm(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionResetPassword()
    {
        return $this->sendResponse(
            new ResetPasswordForm(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionPasswordConfirm()
    {
        return $this->sendResponse(
            new  PasswordConfirmForm(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionSetPassword()
    {
        return $this->sendResponse(
            new  SetPasswordForm(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionIndex()
    {
        return $this->sendResponse(
            new UserListFilter(),
            Yii::$app->request->queryParams
        );
    }

    public function actionMe()
    {
        $user = UserResource::findOne(Yii::$app->user->id);

        return $this->sendModel($user);
    }
    public function actionSetImage()
    {
        return $this->sendResponse(
            new SetUserAvatarForm(new FileResource()),
            Yii::$app->request->bodyParams
        );
    }
    public function actionDelete($id)
    {
        return $this->sendResponse(
            new DeleteUserForm($this->findOne($id)),
            Yii::$app->request->bodyParams
        );
    }

     public function actionLogout()
     {
      return Yii::$app->user->logout();
     }

    public function actionSignup()
    {
        return $this->sendResponse(
            new SignupForm(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionUpdateProfile($id)
    {
        return $this->sendResponse(
            new ProfileUpdateForm($this->findOne($id)),
            Yii::$app->request->bodyParams
        );
    }

    private function findOne($id)
    {
        $model = UserResource::findOne($id);

        return $model;
    }

    public function actionTest()
    {
        dd(phpinfo());
    }


}
