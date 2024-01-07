<?php

function autoload($file){
    //Magy\Managers\RoutesManager;
    //["Magy", "Managers", "RoutesManager"]
    $components = explode('\\', $file);
    $path = '';
    if($components[0] == "Magy"){
        $path = SRC_PATH;
        $componentsCount = sizeof($components);
        for($i = 1;$i < $componentsCount - 1;$i++){
            $path .= strtolower($components[$i]) . '/';
        }
        $path .= $components[$componentsCount - 1];
        require_once $path . '.php';
    }
}

spl_autoload_register("autoload");

?>