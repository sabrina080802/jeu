<?php namespace Magy\Utils;

class ArrayExtension implements \ArrayAccess, \Countable{
    private $size = 0;
    private $container;

    public function __construct($data=null){
        $this->container = $data != null ? $data : array();
        $this->size = sizeof($this->container);
    }
    public function reverse(){
        $this->container = array_reverse($this->container);
    }
    public function get(){
        $args = func_get_args();
        if(sizeof($args) == 1 && is_array($args[0])){
            $args = $args[0];
        }
        $argsCount = sizeof($args);

        $elementsCount = $this->count();
        $result = new ArrayExtension();
        for($i = 0;$i < $elementsCount;$i++){
            $obj = $this->container[$i];
            if($argsCount > 1){
                $newObj = (object)array();
                for($j = 0;$j < $argsCount;$j++){
                    $argName = $args[$j];
                    $newObj->$argName = $obj->$argName;
                }
                $result->push($newObj);
            }
            else{
                $argName = $args[0];
                $result->push($obj->$argName);
            }
        }

        return $result;
    }
    public function toJSON(){
        return json_encode($this->toArray());
    }
    public function first(){
        return $this->count() > 0 ? $this->container[0] : null;
    }
    public function last(){
        return $this->count() > 0 ? $this->container[$this->count() - 1] : null;
    }
    public function toArray(){
        $arr = array();
        $this->size = sizeof($this->container);
        for($i = 0;$i < $this->count();$i++){
            if(!isset($this->container[$i])){
                continue;
            }
            
            array_push($arr, self::convert($this->container[$i]));
        }

        return $arr;
    }
    public function contains($element){
        for($i = 0;$i < $this->count();$i++){
            if($this->container[$i] == $element){
                return true;
            }
        }
        return false;
    }
    public function indexOf($element){
        for($i = 0;$i < $this->count();$i++){
            if($this->container[$i] == $element){
                return $i;
            }
        }
        return -1;
    }
    public function search($delegate){
        for($i = 0;$i < $this->count();$i++){
            if($delegate($this->container[$i])){
                return $this->container[$i];
            }
        }

        return null;
    }
    private static function convert($value){
        switch(true){
            case $value instanceof \DateTime:
                return $value->format('Y-m-d H:i:s');

            case $value instanceof ArrayExtension:
                return $value->toArray();

            case is_object($value):
                foreach($value as $key => $v){
                    $value->$key = self::convert($v);
                }
                break;

            case is_array($value):
                $size = sizeof($value);
                if($size > 0 && isset($value[0])){
                    for($j = 0;$j < $size;$j++){
                        $value[$j] = self::convert($value[$j]);
                    }
                }
                else{
                    foreach($value as $key => $v){
                        $value[$key] = self::convert($v);
                    }
                }
                break;
        }

        return $value;
    }
    public function count():int{
        return $this->size;
    }
    public function offsetSet($offset, $value):void{
        if(is_null($offset)){
            $this->container[] = $value;
        }
        else{
            $this->container[$offset] = $value;
        }

        $count = 0;
        foreach($this->container as $key){
            $count++;
        }
        $this->size = $count;
    }
    public function offsetExists(mixed $offset):bool {
        return isset($this->container[$offset]);
    }
    public function offsetUnset(mixed $offset):void{
        unset($this->container[$offset]);
    }
    public function offsetGet(mixed $offset):mixed{
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    public function removeAt($index){
        array_splice($this->container, $index, 1);
        $this->size--;
    }
    public function insertAt($index, $element){
        array_splice($this->container, $index, 0, [$element]);
    }
    public function unshift($element){
        array_unshift($this->container, $element);
    }
    public function push(){
        $args = func_get_args();
        $argsCount = sizeof($args);
        for($i = 0;$i < $argsCount;$i++){
            $this->offsetSet($this->size, $args[$i]);
        }
    }
    public function merge($array){
        for($i = 0;$i < $array->count();$i++){
            $this->push($array[$i]);
        }
    }
}


?>
