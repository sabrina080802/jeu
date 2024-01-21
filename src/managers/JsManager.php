<?php namespace Magy\Managers;

class JsManager{
    public static function getFramework(){
        return file_get_contents(SRC_PATH . 'js/magy.js');
    }
    private static function includeFiles($path){
        $result = '';
        $fileList = scandir($path);
        $count = sizeof($fileList);
        for($i = 2;$i < $count;$i++){
            if(is_dir($path . $fileList[$i])){
                $result .= self::includeFiles($path . '/' . $fileList[$i]);
            }
            else{
                $result .= file_get_contents($path . '/' . $fileList[$i]) . ';;' . PHP_EOL;
            }
        }

        return $result;
    }
    public static function readFile($name){
        if($name == '**.js'){
            $result = self::includeFiles(JS_PATH);
            echo $result;
            exit;
        }
        else{
            $path = JS_PATH . $name;
            $fileContent = file_get_contents($path);
    
            echo $fileContent;
        }

    }
}


?>