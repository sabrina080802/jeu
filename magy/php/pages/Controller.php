<?php namespace Magy\Pages;

abstract class Controller{
    
    protected $content;

    public function __construct($content){
        $this->content = $content;
        $this->process();
    }
    protected function setValue($varName, $value){

    }
    public function getContent(){
        return $this->content;
    }
    protected abstract function process();
}


?>