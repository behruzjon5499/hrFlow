<?php

namespace api\modules\client\helpers;

class NumberToWordsHelper
{
    private static $ones = [
        0 => '',
        1 => 'bir',
        2 => 'ikki',
        3 => 'uch',
        4 => 'to\'rt',
        5 => 'besh',
        6 => 'olti',
        7 => 'yetti',
        8 => 'sakkiz',
        9 => 'to\'qqiz'
    ];

    private static $tens = [
        2 => 'yigirma',
        3 => 'o\'ttiz',
        4 => 'qirq',
        5 => 'ellik',
        6 => 'oltmish',
        7 => 'yetmish',
        8 => 'sakson',
        9 => 'to\'qson'
    ];

    private static $hundreds = [
        1 => 'bir yuz',
        2 => 'ikki yuz',
        3 => 'uch yuz',
        4 => 'to\'rt yuz',
        5 => 'besh yuz',
        6 => 'olti yuz',
        7 => 'yetti yuz',
        8 => 'sakkiz yuz',
        9 => 'to\'qqiz yuz'
    ];

    /**
     * Raqamni so'zga aylantiradi
     * @param float|int $number
     * @param bool $withCurrency so'm qo'shish
     * @return string
     */
    public static function convert($number, $withCurrency = true)
    {
        // Raqamni butun va kasr qismga ajratish
        $parts = explode('.', number_format($number, 2, '.', ''));
        $integerPart = (int)$parts[0];
        $decimalPart = isset($parts[1]) ? (int)$parts[1] : 0;

        $words = self::convertInteger($integerPart);

        // Agar kasr qism bo'lsa
        if ($decimalPart > 0) {
            $words .= ' butun ' . self::convertInteger($decimalPart);
            if ($withCurrency) {
                $words .= ' tiyin';
            }
        } else {
            if ($withCurrency) {
                $words .= ' so\'m';
            }
        }

        // Birinchi harfni katta qilish
        return ucfirst(trim($words));
    }

    /**
     * Butun sonni so'zga aylantiradi
     * @param int $number
     * @return string
     */
    private static function convertInteger($number)
    {
        if ($number == 0) {
            return 'nol';
        }

        $words = '';

        // Milliardlar
        if ($number >= 1000000000) {
            $billions = floor($number / 1000000000);
            $words .= self::convertHundreds($billions) . ' milliard ';
            $number %= 1000000000;
        }

        // Millionlar
        if ($number >= 1000000) {
            $millions = floor($number / 1000000);
            $words .= self::convertHundreds($millions) . ' million ';
            $number %= 1000000;
        }

        // Minglar
        if ($number >= 1000) {
            $thousands = floor($number / 1000);
            $words .= self::convertHundreds($thousands) . ' ming ';
            $number %= 1000;
        }

        // Yuzlar, o'nlar va birlar
        if ($number > 0) {
            $words .= self::convertHundreds($number);
        }

        return trim($words);
    }

    /**
     * 0-999 oralig'idagi sonni so'zga aylantiradi
     * @param int $number
     * @return string
     */
    private static function convertHundreds($number)
    {
        $words = '';

        // Yuzlar
        if ($number >= 100) {
            $hundreds = floor($number / 100);
            $words .= self::$hundreds[$hundreds] . ' ';
            $number %= 100;
        }

        // O'nlar
        if ($number >= 20) {
            $tens = floor($number / 10);
            $words .= self::$tens[$tens] . ' ';
            $number %= 10;
        } elseif ($number >= 10) {
            // 10-19 oralig'i
            $words .= 'o\'n ';
            $number -= 10;
            if ($number > 0) {
                $words .= self::$ones[$number] . ' ';
            }
            return trim($words);
        }

        // Birlar
        if ($number > 0) {
            $words .= self::$ones[$number] . ' ';
        }

        return trim($words);
    }

    /**
     * Qisqartirilgan variant (faqat asosiy qism)
     * @param float|int $number
     * @return string
     */
    public static function convertShort($number)
    {
        $parts = explode('.', number_format($number, 2, '.', ''));
        $integerPart = (int)$parts[0];

        return ucfirst(trim(self::convertInteger($integerPart)));
    }
}
