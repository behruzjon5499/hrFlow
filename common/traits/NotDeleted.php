<?php

namespace common\traits;

trait NotDeleted
{
    public function notDeleted()
    {
        $tableName = $this->modelClass::tableName();

        $this->andWhere([$tableName.'.deleted_at' => null]);
        
        return $this;
    }
}
