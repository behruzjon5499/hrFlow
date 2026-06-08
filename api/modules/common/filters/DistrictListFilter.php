<?php


namespace api\modules\common\filters;


use api\components\BaseRequest;
use api\modules\common\resources\DistrictResource;

class DistrictListFilter extends BaseRequest
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
        $query = DistrictResource::find()->andWhere(['is_deleted' =>[false,null]])->where(['region_id' => $this->region_id]);
        if ($this->title) {
            $query->andWhere(['like', 'title', $this->title]);
        }
        return paginate($query);
    }
}
