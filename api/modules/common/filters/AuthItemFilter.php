<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\RegionResource;
use backend\modules\rbac\models\RbacAuthItem;
use common\models\AuthItem;

class AuthItemFilter extends BaseRequest
{
    public $name;
    public $all;
    public $type=1;

    public function rules (){
        return [
            [['name','all','type'], 'safe'],
        ];
    }

    public function getResult()
    {
        $query =  AuthItem::find()->andWhere(['type'=>$this->type]);
        if($this->name){
            $query->where(['like','name', $this->name]);
        }
        if($this->all){
            return $query->all();
        }
        $query->orderBy(['order'=>SORT_ASC]);
        return paginate($query);
    }
}