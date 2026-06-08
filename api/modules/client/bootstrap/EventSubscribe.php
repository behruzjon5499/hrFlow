<?php

namespace api\modules\client\bootstrap;


use api\modules\client\events\EvalueViewEvent;
use api\modules\client\listeners\EvalueViewListener;
use yii\base\Application;
use yii\base\BootstrapInterface;

/**
 * Class EventSubscribe
 * @package xbsoft\katm\bootstrap
 */
class EventSubscribe implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        \Yii::$app->on(EvalueViewEvent::class, [EvalueViewListener::class, 'emit']);

    }
}