<?php namespace App\API\Account;

use Magy\Utils\REST;
use Magy\Managers\DbManager;
use App\Services\AuthManager;


//Requête pour se connecter
class Auth extends REST{
    private $account;
    private $success;
    private $error;
    private $token;

    //Définir les paramètres de la requête
    public function getParams(){
        // adresse mail et le mdp verif si c'est les bons, je recupere le compte
        return [
            'email'=>REST::TEXT,
            'pass'=>REST::TEXT
        ];
    }

    //Corps de la requête
    public function process($data){
        $db = DbManager::getDatabase('crossplayarena');
        $this->account = $db->first('SELECT * FROM account WHERE email = :email', $data);
        if($this->account != null && password_verify($data->pass, $this->account['pass']) == true){
            $this->success = true;
            $this->token = AuthManager::createToken($this->account);
        }
        else { $this->error = "mdp incorrect"; }
    }

    //Résultat de la requête
    public function getResponse(){
        return (object)[
            'account' => $this->account,
            'success' => $this->success,
            'error' => $this->error,
            'token' => $this->token
        ];
    }
}


?>