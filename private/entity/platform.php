<?php namespace App\Entity;

use Magy\Managers\DbManager;

class Platform{
	public $identifier;
	public $name;
	public $logo;

    public function __construct($identifier=null, $name=null, $logo=null){
		$this->identifier = $identifier;
		$this->name = $name;
		$this->logo = $logo;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete(){
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM platform WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush(){

    }

    public function copy():Platform{
        return new Platform($this->identifier, $this->name, $this->logo);
    }

    /**
     *@return Platform A newly created platform with given data
     */
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