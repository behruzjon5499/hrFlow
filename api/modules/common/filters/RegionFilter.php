<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;

class RegionFilter extends BaseRequest
{
  public $title;
  public $country_id;

  public function rules()
  {
    return [
      [['title', 'country_id'], 'safe'],
    ];
  }

  public function getResult()
  {
    $query = RegionResource::find()->andWhere(['is_deleted' => [false, null]]);

    if ($this->title) {
      $query->andWhere(['like', 'title', $this->title]);
    }

    if ($this->country_id) {
      $query->andWhere(['parent_id' => $this->country_id]);
    }

    $titleColumn = 'title_' . \Yii::$app->language;
    if (!in_array($titleColumn, ['title_uz', 'title_oz', 'title_ru'], true)) {
      $titleColumn = 'title_uz';
    }
    $query->orderBy([$titleColumn => SORT_ASC]);

    return $query->all();
  }
}
