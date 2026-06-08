<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:20 AM
 */

namespace backend\controllers;

use backend\models\AccountForm;
use backend\models\LoginForm;
use common\helpers\oAuthHelper;
use common\models\User;
use common\rbac\Roles;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\authclient\OAuth2;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SignInController extends Controller
{

    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
//                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::class,
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::class
            ],
            'google' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }


    public function actionLogin()
    {
        $this->layout = 'base';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->userProfile;
        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
            ]);
            return $this->refresh();
        }
        return $this->render('profile', ['model' => $model]);
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        $model->email = $user->email;
        if ($model->load($_POST) && $model->validate()) {
            $user->username = $model->username;
            $user->email = $model->email;
            if ($model->password) {
                $user->setPassword($model->password);
            }
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your account has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('account', ['model' => $model]);
    }

    /**
     * @throws Exception
     */
    public function onAuthSuccess(OAuth2 $client)
    {
        $transaction = Yii::$app->db->beginTransaction();
//         $userOAuth = $client->getUserAttributes();

        $userOAuth =   oAuthHelper::getInfo($client);



        $userNetwork = UserNetworks::find()->andFilterWhere(['or',
            ['network_uid' => $userOAuth['id']]
        ])->one();
        $network = Networks::find()->andWhere(['title'=>$client->getName()])->one();

        if (!$network){
            throw new Exception("Network not found");
        }
        if ($userNetwork) {
            $user = User::findOne($userNetwork->user_id);
            if ($user) {
                $user->updateAttributes(['username'=>$userOAuth['name']]);
                Yii::$app->user->login($user,  3600 * 24 * 30 );
                $transaction->commit();
                return $this->goHome();
            }
        }

        $oldUser = User::find()->andWhere(['email'=>$userOAuth['email']])->one();
        $model = $oldUser?? new User();
        $model->username = $userOAuth['name'];
        $model->email = $userOAuth['email'];
        $model->generateAuthKey();
        $model->setPassword(123456);
        $model->status = User::ACTIVE;

        if (!$model->save(false)) {
            $transaction->rollBack();
            throw new Exception('User save error');
        }
        $newUserNetwork = new UserNetworks();
        $newUserNetwork->user_id = $model->id;
        $newUserNetwork->network_id = $network->id;
        $newUserNetwork->network_uid = $userOAuth['id'];
        $newUserNetwork->image = $userOAuth['image'];
        $newUserNetwork->full_name = $userOAuth['name'];
        $newUserNetwork->email = $userOAuth['email'];
        if (!$newUserNetwork->save(false)) {
            $transaction->rollBack();
            throw new Exception('User Network save error');
        }
        $model->login_network_id = $newUserNetwork->id;
        $model->save();
        Yii::$app->user->login($model,  3600 * 24 * 30  );
        $transaction->commit();
        return $this->goHome();

    }

}
