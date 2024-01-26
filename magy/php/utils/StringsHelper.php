<?php

namespace Magy\Utils;

class StringsHelper
{
    public static function generateKey($keySize)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';
        for ($i = 0; $i < $keySize; $i++) {
            $result .= $alphabet[rand(0, 61)];
        }

        return $result;
    }
    public static function toCamelCase($name)
    {
        $name = trim($name);
        $len = strlen($name);
        $result = '';
        $capitalize = true;
        for ($i = 0; $i < $len; $i++) {
            if ($name[$i] != '_' && $name[$i] != ' ' && $name[$i] != '-') {
                $result .= ($capitalize ? strtoupper($name[$i]) : strtolower($name[$i]));
                $capitalize = false;
            } else {
                $capitalize = true;
            }
        }

        return $result;
    }
    public static function toKebabCase($name)
    {
        $name = trim(mb_strtolower($name));
        $name = str_replace(['é', 'è', 'ê', 'ë'], 'e', $name);
        $name = str_replace(['\'', '"'], '', $name);
        $name = str_replace(['î', 'ï'], 'i', $name);
        $name = str_replace(['â', 'ä'], 'a', $name);
        $name = str_replace(['ô', 'ö'], 'o', $name);
        $name = str_replace('ç', 'c', $name);
        $name = str_replace(['ù', 'û', 'ü'], 'u', $name);
        $name = str_replace('Œ', 'oe', $name);
        $name = str_replace([
            'é', 'è', 'ê', 'ë',
            'ç', 'à', 'ô', 'î', 'ï', '&', '--', ' '
        ], [
            'e', 'e', 'e', 'e',
            'c', 'a', 'o', 'i', 'i', '-et-', '-', '-'
        ], $name);

        preg_match('/([0-9\w\s\-\_\.]+)/', $name, $matchResult);
        $result = trim(preg_replace('/[\-\_\.]/', ' ', $matchResult[0]));
        $result = preg_replace('/\s/', '-', $result);

        return strtolower($result);
    }
}
