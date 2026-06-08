<?php

namespace common\helpers;


class FileHelper
{
    public static function getSrc($path)
    {
        return 'https://api.evalue.uz'. $path;
    }

}