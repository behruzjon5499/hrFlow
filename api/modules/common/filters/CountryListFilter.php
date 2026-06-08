<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;

class CountryListFilter extends BaseRequest
{
    public $title;

    public function rules (){
        return [
            ['title', 'safe'],
        ];
    }

    public function getResult()
    {
        $query = RegionResource::find()->where(['type' => 3]);
        if($this->title){
            $query->where(['like','title', $this->title]);
        }
        return paginate($query);
    }
}