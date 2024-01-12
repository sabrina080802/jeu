<?php namespace Magy\Utils;

abstract class REST{
    const INT = 1;
    const TEXT = 2;
    const JSON = 3;

    public function execute(){
        $requiredParams = $this->getParams();
        $data = (object)[];
        foreach($requiredParams as $key => $value){
            if(!isset($_GET[$key])){
                return false;
            }

            switch($value){
                case REST::INT:
                    if(!is_numeric($_GET[$key])){
                        return false;
                    }
                    else{
                        $data->$key = intval($_GET[$key]);
                    }
                    break;

                case REST::TEXT:
                    $data->$key = $_GET[$key];
                    break;
            }
        }

        $this->process($data);
        return $this->getResponse();
    }
    public abstract function getParams();
    public abstract function process($data);
    public function getResponse() { return null; }
}

?>
