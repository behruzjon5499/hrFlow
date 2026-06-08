<?php


namespace common\components;


use Yii;

class ActiveRecordMeta extends \yii\db\ActiveRecord
{

  public function beforeSave($insert)
  {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->created_at = date("Y-m-d H:i:s");
        $this->updated_at = date("Y-m-d H:i:s");
        if ($this->hasAttribute('created_by'))
          $this->created_by = Yii::$app->user->id ?? 1;
      } else {
        $this->updated_at = date("Y-m-d H:i:s");
        if ($this->hasAttribute('updated_by'))
          $this->updated_by = Yii::$app->user->id;
      }

      return true;
    } else {
      return false;
    }
  }
  //    public function save($runValidation = true, $attributeNames = null)
  //    {
  //
  //
  //
  //        return parent::save($runValidation, $attributeNames);
  //    }

}
