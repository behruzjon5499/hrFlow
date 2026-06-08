<?php

namespace api\modules\common\filters;

use api\components\BaseRequest;
use api\modules\common\resources\FileResource;
use api\modules\common\resources\PlanScheduleResource;

class FileFilter extends BaseRequest
{

  public $id;

  public function rules()
  {
    return [
      ['id', 'required', 'message' => t('{attribute} yuborish majburiy')],
      ['id', 'safe'],
    ];
  }

  public function getResult()
  {
    $query = FileResource::find()->where(['id' => $this->id])->one();
    return $query;
  }
}
