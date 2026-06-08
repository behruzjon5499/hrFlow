<?php

namespace api\modules\backend\controllers;

use yii\rest\Controller;

/**
 * Default controller for the `backend` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return "work";
    }
}
