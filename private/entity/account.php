<?php App\Entity;

class Account{
	public $identifier;
	public $email;
	public $pass;
	public $pseudo;
	public $creationDate;

    public function __construct($identifier=null, $email=null, $pass=null, $pseudo=null, $creationDate=null){
		$this->identifier = $identifier;
		$this->email = $email;
		$this->pass = $pass;
		$this->pseudo = $pseudo;
		$this->creationDate = $creationDate;
    }
    public static function create($identifier=null, $email=null, $pass=null, $pseudo=null, $creationDate=null){
        $entity = new Account();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO account (identifier, email, pass, pseudo, creation_date) VALUES(:identifier,:email,:pass,:pseudo,:creationDate)", [
			"identifier" => $identifier,
			"email" => $email,
			"pass" => $pass,
			"pseudo" => $pseudo,
			"creationDate" => $creationDate
        ]);
    }
}

?>