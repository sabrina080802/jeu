<?php namespace Magy\Managers;

class RoutesManager{
    public function pageExists($url){
        //return file_exists(VIEW_PATH . $url . ".html");
        if(file_exists(VIEW_PATH . $url . ".html")){
            return true;
        }
        else{
            return false;
        }
    }
    public function getPageContent($url){
        // recup le contenu de la page
        $content = file_get_contents(VIEW_PATH . $url . ".html");
        return $content;
    }
}

?>