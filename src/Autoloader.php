<?php

function autoload($file){
    //Magy\Managers\RoutesManager;
    //["Magy", "Managers", "RoutesManager"]
    $components = explode('\\', $file);
    $path = '';
    switch($components[0]){
        case 'Magy':
            $path = SRC_PATH;
            break;
        case 'App':
            $path = APP_PATH;
            break;
        default:
            throw new \Exception("File doesn't exists for namespace \"" . $file . "\"");
    }

    /*if($components[0] == "Magy"){
        $path = SRC_PATH;
    }
    else if($components[0] == "App"){
        $path = APP_PATH;
    }
    else throw new \Exception("File doesn't exists for namespace \"" . $file . "\"");*/

    $componentsCount = sizeof($components);
    for ($i = 1; $i < $componentsCount - 1; $i++) {
        $path .= strtolower($components[$i]) . '/';
    }
    $path .= $components[$componentsCount - 1];
    require_once $path . '.php';}

spl_autoload_register("autoload");

?>