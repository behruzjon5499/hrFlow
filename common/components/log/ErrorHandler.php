<?php

namespace common\components\log;

use Yii;
use yii\web\ErrorHandler as BaseErrorHandler;
use yii\web\Response;

class ErrorHandler extends BaseErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;
        }

        parent::renderException($exception);
    }
}
