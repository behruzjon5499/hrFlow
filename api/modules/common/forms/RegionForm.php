<?php

namespace additional\forms;

use api\components\BaseRequest;
use common\models\Region;

class RegionForm extends BaseRequest
{
  public $parent_id;
  public $type;
  public $title_en;
  public $title_ru;
  public $title_uz;
  public $title_uzk;

  public function rules()
  {
    return [
      [['parent_id', 'type', 'title_en', 'title_ru', 'title_uz', 'title_uzk'], 'required', 'message' => t('{attribute} yuborish majburiy')],
      [['parent_id', 'type'], 'integer'],
      [['title_en', 'title_ru', 'title_uz', 'title_uzk'], 'string'],
    ];
  }

  public function getResult()
  {
    $model = new Region();
    $model->parent_id = $this->parent_id;
    $model->type = $this->type;
    $model->title_en = $this->title_en;
    $model->title_ru = $this->title_ru;
    $model->title_uz = $this->title_uz;
    $model->title_uzk = $this->title_uzk;

    return $model->save();
  }
}
