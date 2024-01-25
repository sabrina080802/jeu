<?php namespace Magy\Utils;

class StringsHelper{
    public static function generateKey($keySize)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $result = '';
        for ($i = 0; $i < $keySize; $i++) {
            $result .= $alphabet[rand(0, 61)];
        }

        return $result;
    }
}


?>