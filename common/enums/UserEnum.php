<?php

namespace common\enums;

interface UserEnum
{
    public const STATUS_NOT_ACTIVE = 1;
    public const STATUS_ACTIVE = 10;
    public const STATUS_DELETED = 3;

    public const LIST = [
        self::STATUS_ACTIVE,
        self::STATUS_NOT_ACTIVE,
        self::STATUS_DELETED,
    ];
}
