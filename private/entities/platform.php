<?php App\Entity;

class Platform{
	public $identifier;
	public $name;
	public $logo;

    public function __construct($identifier=null, $name=null, $logo=null){
		$this->identifier = $identifier;
		$this->name = $name;
		$this->logo = $logo;
    }
    public static function create($identifier=null, $name=null, $logo=null){
        $entity = new Platform();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO platform (identifier, name, logo) VALUES(:identifier,:name,:logo)", [
			"identifier" => $identifier,
			"name" => $name,
			"logo" => $logo
        ]);
    }
}

?>