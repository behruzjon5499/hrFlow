<?php

namespace backend\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/evalue-goal/index']);
    }
//    public function beforeAction($action)
//    {
//        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';
//
//        return parent::beforeAction($action);
//    }
}
