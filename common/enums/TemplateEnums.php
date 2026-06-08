<?php

namespace common\enums;

interface TemplateEnums
{
    const PATIENT_COMPLAINT = 1;
    const HISTORY_OF_ILLNESS = 2;
    const BIOGRAPHY = 3;
    const OBJECTIVE_EXAMINATION = 4;
    const DIAGNOSIS = 5;
    const RECOMMENDATION = 6;

    public const LIST = [
        self::PATIENT_COMPLAINT=>'PATIENT_COMPLAINT',
        self::HISTORY_OF_ILLNESS=>'HISTORY_OF_ILLNESS',
        self::BIOGRAPHY=>'BIOGRAPHY',
        self::OBJECTIVE_EXAMINATION=>'OBJECTIVE_EXAMINATION',
        self::DIAGNOSIS=>'DIAGNOSIS',
        self::RECOMMENDATION=>'RECOMMENDATION',
    ];
}
