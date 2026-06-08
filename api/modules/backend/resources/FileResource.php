<?php


namespace api\modules\backend\resources;

use common\models\File;
use common\models\query\NotDeletedFromCompanyQuery;

class FileResource extends File{

    public function fields(){
        return [
            'id',
            'title',
            'path',
            'size',
            'type',
            'status',
            'fileable_id',
            'fileable_type',
        ];
    }

    public static function find()
    {
        return new NotDeletedFromCompanyQuery(get_called_class());
    }
}