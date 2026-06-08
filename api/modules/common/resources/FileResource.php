<?php


namespace api\modules\common\resources;

use common\models\File;
use common\models\query\NotDeletedFromCompanyQuery;

class FileResource extends File
{

  public function fields()
  {
    return [
      'id',
      'title',
      'path',
      'size',
      'type',
      'status',
      'fileable_id',
      'fileable_type',
      'src',
      'is_deleted',
      'deleted_at',
      'deleted_by',
    ];
  }
    public function getSrc()
    {
        return 'https://api.evalue.uz'.$this->path;
    }
  public static function find()
  {
    return new NotDeletedFromCompanyQuery(get_called_class());
  }
}
