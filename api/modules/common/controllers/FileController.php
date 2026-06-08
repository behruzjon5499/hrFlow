<?php


namespace api\modules\common\controllers;


use api\components\ApiController;
use api\modules\common\filters\FileFilter;
use api\modules\common\forms\FileDeleteForm;
use api\modules\common\forms\FileForm;
use api\modules\common\resources\FileResource;
use Yii;
use yii\web\NotFoundHttpException;

class FileController extends ApiController
{
  public function actionView($id)
  {
    return $this->sendResponse(
      new FileFilter(),
      Yii::$app->request->get()
    );
  }

  public function actionCreate()
  {
    return $this->sendResponse(
      new FileForm(new FileResource()),
      Yii::$app->request->bodyParams
    );
  }

  public function actionDownload($id)
  {

    $path = \Yii::getAlias('@storage').'/web/' . $this->findOne($id)->path;
    if (file_exists($path)) {
      return Yii::$app->response->sendFile($path, $path);
    }

    return null;
  }
  public function actionDownloadFile($id)
  {

    $path = \Yii::getAlias('@storage').'/web/' . $this->findOne($id)->path;
    if (file_exists($path)) {
      return Yii::$app->response->sendFile($path, $path);
    }

    return null;
  }

  //    public function actionUpdate($id) {
  //        return $this->sendResponse(
  //            new FileForm($this->findOne($id)),
  //            Yii::$app->request->bodyParams
  //        );
  //    }

  public function actionDelete($id)
  {
    return $this->sendResponse(
      new FileDeleteForm($this->findOne($id)),
      Yii::$app->request->queryParams
    );
  }

  private function findOne($id)
  {
    $model = FileResource::findOne($id);

    if (!$model) throw new NotFoundHttpException("File not found");

    return $model;
  }

  // action for download file
  // public function actionDownload($id)
  // {
  //   $model = $this->findOne($id);
  //   $path = "C:\\OpenServer\\domains\\xarid-yii2\\storage";
  //   $file = $path . $model->path;

  //   if (file_exists($file)) {
  //     return Yii::$app->response->sendFile($file);
  //   } else {
  //     throw new NotFoundHttpException("File not found, path: $file");
  //   }
  // }
}
