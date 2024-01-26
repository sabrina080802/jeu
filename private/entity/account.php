<?php namespace App\Entity;

class Account{
	public $creationDate;
	public $email;
	public $identifier;
	public $pass;
	public $pseudo;

    public function __construct($creationDate=null, $email=null, $identifier=null, $pass=null, $pseudo=null){
		$this->creationDate = $creationDate;
		$this->email = $email;
		$this->identifier = $identifier;
		$this->pass = $pass;
		$this->pseudo = $pseudo;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete(){
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM account WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush(){

    }

    /**
     *@return Account A newly created account with given data
     */
    public static function create($creationDate=null, $email=null, $identifier=null, $pass=null, $pseudo=null){
        $entity = new Account();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO account (creation_date, email, identifier, pass, pseudo) VALUES(:creationDate,:email,:identifier,:pass,:pseudo)", [
			"creationDate" => $creationDate,
			"email" => $email,
			"identifier" => $identifier,
			"pass" => $pass,
			"pseudo" => $pseudo
        ]);
    }
}

?>