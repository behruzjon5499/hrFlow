<?php

namespace common\components;

use yii\base\Component;
use Hashids\Hashids;

class HashidsComponent extends Component
{
    public $salt;
    public $minHashLength;
    private $hashids;

    public function init()
    {
        parent::init();
        $this->hashids = new Hashids($this->salt, $this->minHashLength);
    }

    public function encode($id)
    {
        return $this->hashids->encode($id);
    }

    public function decode($encodedId)
    {
        $decoded = $this->hashids->decode($encodedId);
        return isset($decoded[0]) ? $decoded[0] : null;
    }
}
