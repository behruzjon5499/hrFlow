<?php


namespace api\modules\backend\resources;

use common\models\Region;

class DistrictResource extends Region
{
    public function fields()
    {
        return [
            'id',
            'title_ru',
            'title_en',
            'title_uz',
            'title_uzk',
            'parent_id',
            'type'
        ];
    }

    public function extraFields()
    {
        return [
            'region'
        ];
    }
}
