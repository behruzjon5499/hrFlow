<?php

namespace api\components;

use Yii;
use yii\base\Model;
use yii\rest\Controller;
use yii\rest\OptionsAction;

abstract class ApiController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            $user = Yii::$app->user;

            if ($user->isGuest && Yii::$app->request->headers->has('Authorization')) {
                $token = Yii::$app->request->headers->get('Authorization');
                if ($token !== null && preg_match('/^Bearer\s+(.*?)$/', $token, $matches)) {
                    $token = $matches[1];
                }
                $identity = $user->identityClass::findIdentityByAccessToken($token);
                if ($identity !== null) {
                    Yii::$app->user->login($identity);
                }
            }
            return true;
        }
        return false;
    }
  public function behaviors()
  {
    return parent::behaviors() + [
      'corsFilter' => [
        'class' => \yii\filters\Cors::class,
        'cors' => [
          // restrict access to
          'Origin' => ['http://localhost:3000', 'http://dxp.uz', 'http://dxp.uz/', 'http://dxp.uz/common/file/create', 'http://ebirja.uz', 'http://ebirja.uz/'],
          // Allow only POST and PUT methods
          'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT'],
          // Allow only headers 'X-Wsse'
           'Access-Control-Request-Headers' => ['Origin', 'Content-Type', 'X-Auth-Token' , 'Authorization', 'Accept', 'Referer', 'User-Agent', 'Headers'],
          // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
          'Access-Control-Allow-Credentials' => true,
          // Allow OPTIONS caching
          'Access-Control-Max-Age' => 3600,
          // Allow the X-Pagination-Current-Page header to be exposed to the browser.
          // 'Access-Control-Expose-Headers' => ['Origin', 'Content-Type', 'X-Auth-Token', 'Authorization'],
        ],
      ],
      [
        'class' => \yii\filters\ContentNegotiator::class,
        'formats' => [
          'application/json' => \yii\web\Response::FORMAT_JSON,
        ],
      ],


      'bearerAuth' => [
        'class' => \yii\filters\auth\HttpBearerAuth::class,


        'except' => [
          'options',
          'login',
          'challenge',
          'login-pks7',
          'login-pks7-ping',
          'signup',
          'signup-no-resident',
          'region-list',
          'district-list',
          'active',
          'active-lots',
          'index',
          'service-list',
          'doctor-list',
          'reset-password',
          'password-confirm',
          'set-password',
          'test',

        ],


         'optional' => [
             'active-lots-view',
             'offers',
             'download-file',
             'mfo-list',
             'auction-view',
             'announce-list',
             'product-view',
             'product-detail',
             'black-list',
             'statistics',
             'classifier-category-list',
             'classifier-list',
             'country-list',
             'list-district',
             'get-protocol',
             'get-discussion-protocol',
             'feedback-create'
         ]
      ],
      //      'access' => [
      //        'class' => AccessControl::class,
      //        'rules' => [
      //           /*commission*/
      //            [
      //                'controllers' => [
      //                    'tender',
      //                ],
      //                'actions' => [
      //                    'commission-index'
      //                ],
      //
      //                'allow' => true,
      //                'roles' => ['commission'],
      //            ],
      //
      //
      //        ], // rules
      //
      //      ], // access
    ];
  }
  public $enableCsrfValidation = false;


  public function actionOptions()
  {
    return true;
  }

  public function actions()
  {
    return [
      'options' => [
        'class' => OptionsAction::class
      ]
    ];
  }

  protected function sendResponse(Model $model, $params = [])
  {
    $model->load($params, '');

    if ($model->validate()){
        $result = $model->getResult();


        if($result == false && !is_array($result)){
            Yii::$app->response->statusCode = 422;
        }

        return [
            'result' => $result,
            'errors' => $model->errors
        ];
    }
    else {

      Yii::$app->response->statusCode = 422;

      return [
        'result' => null,
        'errors' => $model->errors,
      ];
    }
  }

  protected function sendModel($model)
  {
    return [
      'result' => $model,
      'errors' => null
    ];
  }
}
