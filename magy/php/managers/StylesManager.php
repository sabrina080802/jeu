<?php

namespace Magy\Managers;

class StylesManager
{
    private static function includeFiles($path)
    {
        $result = '';
        $fileList = scandir($path);
        $count = sizeof($fileList);
        for ($i = 2; $i < $count; $i++) {
            if (is_dir($path . $fileList[$i])) {
                $result .= self::includeFiles($path . '/' . $fileList[$i]);
            } else {
                $result .= file_get_contents($path . '/' . $fileList[$i]) . PHP_EOL;
            }
        }

        return $result;
    }
    public static function readFile($name)
    {
        if ($name[0] == '/') {
            $name = substr($name, 1);
        }
        if ($name == '**.css' || $name == '_.css') {
            return self::includeFiles(CSS_PATH);
        } else {
            return file_get_contents(CSS_PATH . $name);
        }
    }
}
