<?php

namespace common\enums;

interface RoleEnum
{
    const BANKER = 'banker';
    const EVALUATOR = 'evaluator';
    const ADMIN = 'admin';

    public const ROLES = [
        self::BANKER,
        self::EVALUATOR,
        self::ADMIN
    ];
}