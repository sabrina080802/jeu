<?php namespace Magy\Managers;

class RoutesManager{
    public function getAPIRequest($url){
        // /boutique
        // account/getAccount
        $url = explode('/', strtolower($url));
        // ['account', 'getaccount']

        $componentsCount = sizeof($url); // 2
        $path = API_PATH; //chemin de base
        $ns = 'App\\API'; //namespace de la classe
        for($i = 0;$i < $componentsCount;$i++){
            $fileList = scandir($path); //tableau qui contient la liste des fichiers dans le chemin  ["account"]
            $fileCount = sizeof($fileList); //nbre fichiers

            if($i == $componentsCount - 1){
                $url[$i] .= '.php'; //on ajoute l'extension à la fin si c'est le dernier du tableau $url
            }

            //parcours la liste des fichiers
            for($j = 0;$j < $fileCount;$j++){
                if(strtolower($fileList[$j]) == $url[$i]){
                    $path .= $fileList[$j];
                    if(!is_file($path)){
                        $path .= '/'; // construire le chemin pour continuer de parcourir
                        $ns .= '\\' . $fileList[$j]; //Construire le namespace pour pouvoir créer l'objet
                    }
                    
                    if($i == $componentsCount - 1){
                        return $ns .'\\' . str_replace('.php', '', $fileList[$j]); //Construire le namespace pour pouvoir créer l'objet
                    }
                    else break;
                }
            }
        }

        return null;
    }
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