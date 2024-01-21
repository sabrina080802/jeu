<?php namespace App\API\Account;

use Magy\Utils\REST;
use Magy\Managers\DbManager;

class GetAccount extends REST{
    private $account;

    public function getParams(){
        return [
            'id' => REST::INT
        ];
    }
    public function process($data){
        $db = DbManager::getDatabase('crossplayarena');
        $this->account = $db->first('SELECT * FROM account WHERE identifier = @id', $data);
    }
    public function getResponse(){
        return $this->account;
    }
}


?>