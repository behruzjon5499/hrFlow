<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;

class CountryFilter extends BaseRequest
{
    public $title;

    public function rules (){
        return [
            ['title', 'safe'],
        ];
    }

    public function getResult()
    {
        $query = RegionResource::find()->where(['type' => [3,4]]);
        if($this->title){
            $query->where(['like','title', $this->title]);
        }
        $query->orderBy(['order'=>SORT_ASC]);
        return $query->all();
    }
}