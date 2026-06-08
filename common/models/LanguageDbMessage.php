<?php

namespace common\models;

use yii\i18n\DbMessageSource;


class LanguageDbMessage extends DbMessageSource
{

    public $sourceMessageTable = '{{%i18n_source_message}}';
    public $messageTable = '{{%i18n_message}}';
}
