<?php App\Entity;

class AuthToken{
	public $identifier;
	public $token;
	public $account;

    public function __construct($identifier=null, $token=null, $account=null){
		$this->identifier = $identifier;
		$this->token = $token;
		$this->account = $account;
    }
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