<?php

namespace api\modules\common\controllers;

use api\components\ApiController;
use api\modules\common\filters\BankFilter;
use yii\web\Controller;

/**
 * Default controller for the `common` module
 */
class DefaultController extends ApiController
{
  /**
   * Renders the index view for the module
   * @return string
   */
  public function actionIndex()
  {
    return "common module ishlayapti";
  }

  public function actionMfoList()
  {
      return $this->sendResponse(
          new BankFilter(),
          \Yii::$app->request->queryParams
      );
  }

}
