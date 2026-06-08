<?php

namespace common\generators\mvc\helpers;

class AttributeHelper
{
    public static function getCommonAttributesList():array
    {
        return [
            'id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by',
            'is_deleted',
            'status'
        ];
    }

}