<?php

function autoload($file)
{
    $components = explode('\\', $file);
    $path = '';
    switch ($components[0]) {
        case 'Magy':
            $path = MAGY_PATH . 'php/';
            break;
        case 'App':
            $path = PRIVATE_APP_PATH;
            break;
        default:
            throw new \Exception("File doesn't exists for namespace \"" . $file . "\"");
    }

    $componentsCount = sizeof($components);
    for ($i = 1; $i < $componentsCount - 1; $i++) {
        $path .= strtolower($components[$i]) . '/';
    }
    $path .= $components[$componentsCount - 1];
    require_once $path . '.php';
}

spl_autoload_register("autoload");
