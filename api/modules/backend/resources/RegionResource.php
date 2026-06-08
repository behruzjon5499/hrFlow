<?php


namespace api\modules\backend\resources;


use common\models\Region;

class RegionResource extends Region
{
    public function fields(){
        return [
            'id',
            'type',
            'title_ru',
            'title_en',
            'title_uz',
            'title_uzk',
        ];
    }

    public function extraFields()
    {
        return [
            'districts'
        ];
    }
}