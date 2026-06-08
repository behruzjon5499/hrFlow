<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\RegionFilter;
use Yii;

class RegionController extends ApiController
{
  public function actionIndex()
  {
    return $this->sendResponse(
      new RegionFilter(),
        Yii::$app->request->queryParams
    );
  }
    public function actionRegionWithDistrict()
    {
        return $this->sendResponse(
            new RegionWithDistrictFilter(),
            Yii::$app->request->queryParams
        );
    }
}
