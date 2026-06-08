<?php

namespace common\helpers;


class DateHelper
{

    public static function date($time)
    {

        $years   = floor($time / (365*60*60*24));
        $months  = floor(($time - $years * 365*60*60*24) / (30*60*60*24));
        $days    = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $hours   = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));

        $minuts  = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

        $seconds = ($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60);
        $data = '';

        $data.= $days != 0 ? $days.' Kun ':'';
        $data.= $hours != 0 ? $hours.' Soat ':'';
        $data.= $minuts != 0 ? $minuts.' Minut ':'';
        $data.= $seconds != 0 ? $seconds.' Sekund ':'';
//DdHelper::dd($diff);
        return $data;


    }

}