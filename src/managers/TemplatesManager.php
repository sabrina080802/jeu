<?php namespace Magy\Managers;

class TemplatesManager{
    public function translate($pageContent){
        $count = preg_match_all('/\{\{([\w\d\.]+)\}\}/', $pageContent, $matches);

        for($i = 0;$i < $count;$i++){
            $path = TEMPLATES_PATH . str_replace('.', '/', $matches[1][$i]) . '.html';
            if(file_exists($path)){
                $pageContent = str_replace('{{' . $matches[1][$i] . '}}', file_get_contents($path), $pageContent);
            }
        }

        return $pageContent;
    }
}

?>