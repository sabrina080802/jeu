<?php namespace App\Entity;

use Magy\Managers\DbManager;

class AuthToken{
	public $identifier;
	public $token;
	public $account;

    public function __construct($identifier=null, $token=null, $account=null){
		$this->identifier = $identifier;
		$this->token = $token;
		$this->account = $account;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete(){
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM auth_token WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush(){

    }

    public function copy():AuthToken{
        return new AuthToken($this->identifier, $this->token, $this->account);
    }

    /**
     *@return AuthToken A newly created auth_token with given data
     */
    public static function create($identifier=null, $token=null, $account=null){
        $entity = new AuthToken();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO auth_token (identifier, token, account) VALUES(:identifier,:token,:account)", [
			"identifier" => $identifier,
			"token" => $token,
			"account" => $account
        ]);
    }
}

?>