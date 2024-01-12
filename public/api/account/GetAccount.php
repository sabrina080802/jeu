<?php namespace App\API\Account;

use Magy\Utils\REST;

class GetAccount extends REST{
    public function getParams(){
        return [
            'id' => REST::INT
        ];
    }
    public function process($data){
    }
}


?>