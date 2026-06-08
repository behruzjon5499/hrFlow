<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\RbacGroupFilter;
use api\modules\common\filters\RbacHeaderFilter;
use api\modules\common\forms\AuthItemCreateForm;
use api\modules\common\filters\AuthItemFilter;
use api\modules\common\forms\AuthItemDeleteForm;
use api\modules\common\forms\AuthItemUpdateForm;
use api\modules\common\forms\RbacGroupCreateForm;
use api\modules\common\forms\RbacGroupDeleteForm;
use api\modules\common\forms\RbacGroupUpdateForm;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\RbacGroup;
use Yii;
use yii\base\Exception;

class RbacHeaderController extends ApiController
{
    public function actionIndex()
    {
        return $this->sendResponse(
            new RbacHeaderFilter(),
            Yii::$app->request->queryParams
        );
    }
    public function actionCreate()
    {
        return $this->sendResponse(
            new RbacGroupCreateForm(new RbacGroup()),
            Yii::$app->request->bodyParams
        );
    }
    public function actionUpdate($id)
    {
        return $this->sendResponse(
            new   RbacGroupUpdateForm($this->findOne($id)),
            Yii::$app->request->bodyParams
        );
    }
    public function actionDelete($id)
    {
        return $this->sendResponse(
            new RbacGroupDeleteForm($this->findOne($id)),
            Yii::$app->request->queryParams
        );
    }
    public function actionView($id)
    {
        return $this->sendModel($this->findOne($id));
    }

    /**
     * @throws Exception
     */
    private function findOne($name)
    {
        $model =  RbacGroup::findOne($name);

        if (!$model){
            throw new Exception(t(" RbacGroup not found"));
        }
        return $model;
    }
}