<?php


namespace api\modules\common\resources;


use common\models\Region;
use Yii;

class RegionResource extends Region
{

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['title_ru']);
        unset($fields['title_uz']);
        unset($fields['title_en']);
        $fields['title'] = 'title';
        return $fields;
    }

    public function getTitle()
    {
        $title = 'title_' . Yii::$app->language;
        return $this->attributes[$title];
    }
}
