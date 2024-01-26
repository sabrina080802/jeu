<?php App\Entity;

class Game{
	public $identifier;
	public $name;

    public function __construct($identifier=null, $name=null){
		$this->identifier = $identifier;
		$this->name = $name;
    }
    public static function create($identifier=null, $name=null){
        $entity = new Game();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO game (identifier, name) VALUES(:identifier,:name)", [
			"identifier" => $identifier,
			"name" => $name
        ]);
    }
}

?>