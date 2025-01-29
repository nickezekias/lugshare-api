<?php

namespace App\Helpers;

class MyStr
{
    /**
     * Extract User Agent
     *
     * @parma string str
     */
    public static function extractUserAgent (string $str): string
    {
        $len = strlen($str);
        $geckoPos = strpos($str, "Gecko");
        $browserNameAndVersion = substr($str, $geckoPos, $len);

        $browserWithVersion = substr($browserNameAndVersion, strpos($browserNameAndVersion, " "), strlen($browserNameAndVersion));
        return substr($browserWithVersion, 0, strpos($browserWithVersion, "/"));
    }

    /**
     * Format timestamp to ago type date
     * @param str
     */
    public static function extractDate (string $str): string
    {
        $str = (int)$str;
        $str = time() - $str;


        if ($str < 60) {
            return $str."-sec";
        } else if ($str >= 60 && $str < 3600) {
            $str = $str / 60;
            round($str, 2);
            return $str."-min";
        } else if ($str >= 3600 && $str < 86400) {
            $str = $str / 3600;
            $str = round($str, 2);
            $str = round((int)$str, 0, PHP_ROUND_HALF_DOWN);
            // return substr($str, 0, strpos($str, ","))."-day";
            return $str."-hour";
        } else if ($str >= 86400 && $str < 604800) {
            $str = $str / 86400;
            round($str, 0, PHP_ROUND_HALF_DOWN);
            return $str."-day";
        } else if ($str >= 604800) {
            $str = $str / 604800;
            round($str, 2);
            return $str."-week";
        } else if ($str >= 2629743 && $str < 31556926) {
            $str = $str / 2629743;
            round($str, 2);
            return $str."-month";
        } else if ($str >= 31556926) {
            $str = $str / 31556926;
            round($str, 2);
            return $str."-year";
        } else {
            return $str;
        }
    }
}
