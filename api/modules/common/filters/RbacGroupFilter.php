<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;
use common\models\RbacGroup;

class RbacGroupFilter extends BaseRequest
{
    public $title;
    public $all;

    public function rules (){
        return [
            [['title','all'], 'safe'],
        ];
    }

    public function getResult()
    {
        $query = RbacGroup::find();
        if($this->title){
            $query->where(['like','title', $this->title]);
        }
        if($this->all){
            return $query->all();
        }
        return paginate($query);
    }
}