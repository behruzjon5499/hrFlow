<?php

namespace api\components;

use yii\base\Model;

abstract class BaseRequest extends Model
{
    public abstract function getResult();
}
