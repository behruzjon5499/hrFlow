<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\CountryFilter;
use api\modules\common\filters\CountryListFilter;
use Yii;

class CountryController extends ApiController
{
    public function actionIndex()
    {
        return $this->sendResponse(
            new CountryFilter(),
            Yii::$app->request->queryParams
        );
    }
    public function actionCountryList()
    {
        return $this->sendResponse(
            new CountryListFilter(),
            Yii::$app->request->queryParams
        );
    }

}