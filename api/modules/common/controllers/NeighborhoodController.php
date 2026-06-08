<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\client\filters\NeighborhoodFilter;
use Yii;

class NeighborhoodController extends ApiController
{
    public function actionIndex($district_id)
    {
        return $this->sendResponse(
            new NeighborhoodFilter(),
            Yii::$app->request->queryParams
        );
    }

}
