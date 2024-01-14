<?php namespace Magy\Managers;

class JsManager{
    public static function getFramework(){
        return file_get_contents(SRC_PATH . 'js/magy.js');
    }
    public static function readFile($name){
        $path = JS_PATH . $name;
        $fileContent = file_get_contents($path);

        echo $fileContent;
    }
}


?>