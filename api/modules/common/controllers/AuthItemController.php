<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\PermissionLeftFilter;
use api\modules\common\filters\PermissionTopFilter;
use api\modules\common\forms\AuthItemCreateForm;
use api\modules\common\filters\AuthItemFilter;
use api\modules\common\forms\AuthItemDeleteForm;
use api\modules\common\forms\AuthItemUpdateForm;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\AuthItem;
use Yii;
use yii\base\Exception;

class AuthItemController extends ApiController
{
    public function actionIndex()
    {
        return $this->sendResponse(
            new AuthItemFilter(),
            Yii::$app->request->queryParams
        );
    }
    public function actionCreate()
    {
        return $this->sendResponse(
            new AuthItemCreateForm(new AuthItem()),
            Yii::$app->request->bodyParams
        );
    }
    public function actionUpdate($name)
    {
        return $this->sendResponse(
            new   AuthItemUpdateForm($this->findOne($name)),
            Yii::$app->request->bodyParams
        );
    }
    public function actionPermissionLeft()
    {
        return $this->sendResponse(
            new  PermissionLeftFilter(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionPermissionTop()
    {
        return $this->sendResponse(
            new  PermissionTopFilter(),
            Yii::$app->request->bodyParams
        );
    }
    public function actionDelete($name)
    {
        return $this->sendResponse(
            new AuthItemDeleteForm($this->findOne($name)),
            Yii::$app->request->queryParams
        );
    }
    public function actionView($name)
    {
        return $this->sendModel($this->findOne($name));
    }

    /**
     * @throws Exception
     */
    private function findOne($name)
    {
        $model =  AuthItem::findOne($name);

        if (!$model){
            throw new Exception(t(" AuthItem not found"));
        }
        return $model;
    }
}