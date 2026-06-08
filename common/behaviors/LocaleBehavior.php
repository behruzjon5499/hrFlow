<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Application;

/**
 * Class LocaleBehavior
 * @package common\behaviors
 */
class LocaleBehavior extends Behavior
{
    /**
     * @var string
     */
    public $cookieName = 'language';

    /**
     * @var bool
     */
    public $enablePreferredLanguage = true;

    /**
     * @return array
     */
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    /**
     * Resolve application language by checking user cookies, preferred language and profile settings
     */
    public function beforeRequest()
    {
      $queryParams =   Yii::$app->getRequest()->getHeaders();
      if (isset($queryParams['Accept-Language']) && in_array($queryParams['Accept-Language'],['ru','uz','oz'])){
          Yii::$app->language = $queryParams['Accept-Language'];
      }
      else{
          Yii::$app->language = 'uz';
      }
    }

    public function resolveLocale()
    {

    }

    /**
     * @return array
     */
    protected function getAvailableLocales()
    {
        return array_keys(Yii::$app->params['availableLocales']);
    }
}
