<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\DistrictFilter;
use api\modules\common\filters\DistrictListFilter;
use Yii;

class DistrictController extends ApiController
{
  public function actionIndex($region_id)
  {
    return $this->sendResponse(
      new DistrictFilter(),
        Yii::$app->request->queryParams
    );
  }
    public function actionListDistrict($region_id)
    {
        return $this->sendResponse(
            new DistrictListFilter(),
            Yii::$app->request->queryParams
        );
    }
}
