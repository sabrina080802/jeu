<?php

namespace Magy\Managers;

class JsManager
{
    public static function getFramework()
    {
        return self::includeFiles(MAGY_PATH . 'js/');
    }
    private static function includeFiles($path)
    {
        $result = '';
        $fileList = scandir($path);
        $count = sizeof($fileList);
        for ($i = 2; $i < $count; $i++) {
            if (is_dir($path . $fileList[$i])) {
                $result .= self::includeFiles($path . $fileList[$i] . '/');
            } else {
                $result .= file_get_contents($path . $fileList[$i]) . ';;' . PHP_EOL;
            }
        }

        return $result;
    }
    public static function readFile($name)
    {
        if ($name[0] == '/') {
            $name = substr($name, 1);
        }
        if ($name == '**.js' || $name == '_.js') {
            return self::includeFiles(JS_PATH);
        } else {
            return file_get_contents(JS_PATH . $name);
        }
    }
}
