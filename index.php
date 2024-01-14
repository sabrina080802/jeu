<?php

include "config.php";
include SRC_PATH . "Autoloader.php";

use Magy\Managers\RoutesManager;
use Magy\Managers\TemplatesManager;
use Magy\Managers\JsManager;

$route = new RoutesManager();

//http://google.com/index.php?test=2
//$_GET['test'] == 2
//$_POST['test']

$page = str_replace(ROOT_PATH, '', $_GET['page']);
$ext = explode('.', $page);
if(sizeof($ext) == 1) {
    //page can be empty
    if($page == ''){
        //afficher home
        $pageContent = $route->getPageContent('home');
    }
    else{
        $apiRequest = $route->getAPIRequest($page);
        if($apiRequest != null){
            $req = new $apiRequest();
            $pageContent = $req->execute();
            if($pageContent === false){
                http_response_code(400);
                return;
            }
        }
        else if($route->pageExists($page)) {
            //afficher $page.html
            $pageContent = $route->getPageContent($page);
        }
        else{
            //show 404
            $pageContent = $route->getPageContent('404');
        }
    }
    
    $templates = new TemplatesManager();
    $pageContent = $templates->translate($pageContent);
    $pageContent = str_replace('<head>', '<head><script>' . JsManager::getFramework() . '</script>', $pageContent);
    echo $pageContent;
}
else{
    $ext = $ext[sizeof($ext) - 1];
    $path = '';
    switch($ext){
        case 'css':
            $path = CSS_PATH . $page;
            header('content-type: text/css');
            break;

        case 'js':
            JsManager::readFile($page);
            header('content-type: text/javascript');
            return;

        case 'png':
        case 'jpg':
        case 'webp':
        case 'jpeg':
            $path = IMAGES_PATH . $page;
            header('content-type: image/' . $ext);
            break;

        case 'ttf':
        case 'otf':
        case 'woff':
            $path = FONTS_PATH . $page;
            header('content-type: font/' . $ext);
            break;
    }

    if(file_exists($path)){
        echo file_get_contents($path);
    }
    else{
        http_response_code(404);
    }
}

?>