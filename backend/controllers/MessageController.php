<?php

namespace backend\controllers;
use backend\models\Functions;
use Yii;
use common\models\Message;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\SourceMessageSearch;
use common\models\SourceMessage;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider -> pagination = ['pageSize' => 20];

        return $this->render('grid', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $model = $this->findModelMessage($id);
        $model2 = Message::find()->asArray()->where(['id'=>$id])->all();

        return $this->render('view', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    protected function findModelMessage($id)
    {
        if (($model = SourceMessage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }

    public function actionCreate()
    {
        $model = new Message();
        $model2 = new SourceMessage();
        $model2->category = 'main';

        if ($model->load(Yii::$app->request->post()) and $model2->load(Yii::$app->request->post()) ) {
            $a =  Functions::clearEmpty($_POST['Message']['trans_message'],true);
            $i = 0;
            if (empty($a)) {
                Yii::$app->session->setFlash('error',Yii::t('yii','Fill in all fields'));
                return $this->render('create', [
                    'model' => $model,
                    'model2' => $model2,
                ]);
            }else{
                if($model2->save()){

                    foreach ($_POST['Message']['trans_message'] as $key=>$value) {
                        if (!empty($value)) {
                            $model = new Message();
                            $model->id = $model2->id;
                            $model->language = $key;
                            $model->translation = $value;
                            $model->save();
                            $i = 1;
                        }
                    }
                }else{
                    Yii::$app->session->setFlash('error',Yii::t('yii','Fill in all fields'));
                    return $this->render('create', [
                        'model' => $model,
                        'model2' => $model2,
                    ]);
                }
            }
            if ($i==1) {
                Yii::$app->session->setFlash('success',Yii::t('yii','Successfully saved!!!'));
                return $this->redirect(['view', 'id' => $model2->id]);

            }else {
                Yii::$app->session->setFlash('error',Yii::t('yii','Something Error!!!'));
                return $this->render('create', [
                    'model' => $model,
                    'model2' => $model2,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2 = $this->findModelMessage($id);

        $old = Message::find()->asArray()->where(['id'=>$model2->id])->all();
        if(!$model->isNewRecord){
            foreach ($old as $value) {
                $model->trans_message[$value['language']] = $value['translation'];
            }
        }
        if ($model2->load(Yii::$app->request->post()) ) {
            $a =  Functions::clearEmpty($_POST['Message']['trans_message'],true);
            $i = 0;
            if (empty($a)) {
                Yii::$app->session->setFlash('error',Yii::t('yii','Fill in all fields'));
                return $this->render('update', [
                    'model' => $model,
                    'model2' => $model2,
                ]);
            }else{
                if($model2->save()){
                    Message::deleteAll(['id'=>$model2->id]);
                    foreach ($_POST['Message']['trans_message'] as $key=>$value) {
                        if (!empty($value)) {
                            $model = new Message();
                            $model->id = $model2->id;
                            $model->language = $key;
                            $model->translation = $value;
                            $model->save();
                            $i = 1;
                        }
                    }
                }else{
                    Yii::$app->session->setFlash('error',Yii::t('yii','Fill in all fields'));
                    return $this->render('update', [
                        'model' => $model,
                        'model2' => $model2,
                    ]);
                }
            }
            if ($i==1) {
                Yii::$app->session->setFlash('success',Yii::t('yii','Successfully saved!!!'));
                return $this->redirect(['view', 'id' => $model2->id]);

            }else {
                Yii::$app->session->setFlash('error',Yii::t('yii','Something Error!!!'));
                return $this->render('update', [
                    'model' => $model,
                    'model2' => $model2,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'model2' => $model2,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = Message::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModelMessage($id);
        Message::deleteAll(['id'=>$id]);
        $model->delete();
        Yii::$app->session->setFlash('success',Yii::t('yii','Successfully deleted!!!'));
        return $this->redirect(['index']);
    }
}

