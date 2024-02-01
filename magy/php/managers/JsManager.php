<?php

namespace Magy\Managers;

/**
 * Provides JS files
 */
class JsManager
{
    /**
     * @return string The entire Magy JS Framework
     */
    public static function getFramework(): string
    {
        return self::includeFiles(MAGY_PATH . 'js/');
    }
    /**
     * @param string $path A full path containing JS files
     * @return string include all JS files in $path
     */
    private static function includeFiles(string $path): string
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
    /**
     * Reads a JS file and returns the content
     * @param string $name the name of the file. If "_.js" or "**.js", returns the entire content of JS App
     * @return string JS file content
     */
    public static function readFile(string $name): string
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
