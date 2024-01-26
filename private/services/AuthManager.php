<?php namespace App\Services;

use Magy\Utils\StringsHelper;
use Magy\Managers\DbManager;

class AuthManager{
    public static function createToken($account){
        $token = StringsHelper::generateKey(25);
        return AuthToken::create(null, $token, $account['identifier']);

        /*$db = DbManager::getDatabase('crossplayarena');
        $db->query('INSERT INTO token (token, account) VALUES(:token, :account)', [
            'account' => $account['identifier'],
            'token' => $token
        ]);

        return $token;*/
    }
    public static function isAuth(){
        
    }
}


?>