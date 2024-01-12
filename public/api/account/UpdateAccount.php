<?php
namespace App\API\Account;

use Magy\Utils\REST;

class UpdateAccount extends REST
{
    public function getParams()
    {
        return [
            'id' => REST::INT,
            'name' => REST::TEXT
        ];
    }
    public function process($data)
    {
        
    }
}


?>