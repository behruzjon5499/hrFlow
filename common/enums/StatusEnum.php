<?php

namespace common\enums;

interface StatusEnum
{
    const STATUS_NEW = 100;
    const STATUS_VIEWED = 200;
    const STATUS_ACTIVE = 300;
    const STATUS_NOT_ACTIVE = 400;
    const STATUS_DELETED = 500;
    const STATUS_CHANGED = 510;

  public const LIST = [
    self::STATUS_ACTIVE,
    self::STATUS_NOT_ACTIVE,
    self::STATUS_DELETED,
  ];
}
