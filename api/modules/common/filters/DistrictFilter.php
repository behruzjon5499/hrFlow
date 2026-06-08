<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\DistrictResource;

class DistrictFilter extends BaseRequest
{
  public $title;
  public $region_id;

  public function rules()
  {
    return [
      ['title', 'safe'],
      ['region_id', 'integer'],
      ['region_id', 'required', 'message' => t('{attribute} yuborish majburiy')],
    ];
  }

  public function getResult()
  {
    $query = DistrictResource::find()->where(['region_id' => $this->region_id]);

    if ($this->title) {
      $query->andWhere([
        'OR',
        ['ilike', 'title_uz', $this->title],
        ['ilike', 'title_oz', $this->title],
        ['ilike', 'title_ru', $this->title],
      ]);
    }

    $titleColumn = 'title_' . \Yii::$app->language;
    if (!in_array($titleColumn, ['title_uz', 'title_oz', 'title_ru'], true)) {
      $titleColumn = 'title_uz';
    }
    $query->orderBy([$titleColumn => SORT_ASC]);

    return $query->all();
  }
}
