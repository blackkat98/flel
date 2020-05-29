<?php

namespace App\Helper;

use App\Enums\AcuteAccent;

class AccentReduction
{
    /**
     * Collect Accent Lists from Enum.
     *
     * @return array
     */
    public static function getAccentTable()
    {
        return AcuteAccent::toArray();
    } 

    /**
     * Remove Accents from Latin-Originated Words.
     *
     * @param  string  $str
     * @return string
     */
    public static function normalize($str)
    {
        $accents = static::getAccentTable();

        foreach ($str as $char) {
            foreach ($accents as $key => $value) {
                if (in_array($char, $value)) {
                    $str = str_replace($char, $key, $str);
                }
            }
        }

        return $str;
    }
}