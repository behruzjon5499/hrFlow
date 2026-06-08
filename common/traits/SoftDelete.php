<?php

namespace common\traits;

use Yii;

trait SoftDelete
{
  public function delete()
  {
    $this->deleted_at = date("Y-m-d H:i:s");
    $this->updated_by = Yii::$app->user->id;
    return $this->save();

  }

  // get all records that deleted_at is null
  public static function find()
  {
    return parent::find()->where([self::tableName().'.deleted_at' => null]);
  }
}
