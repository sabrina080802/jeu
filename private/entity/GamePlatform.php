<?php namespace App\Entity;

use Magy\Managers\DbManager;

class GamePlatform{
	public $game;
	public $platform;

    public function __construct($game=null, $platform=null){
		$this->game = $game;
		$this->platform = $platform;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete(){
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM game_platform WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush(){

    }

    public function copy():GamePlatform{
        return new GamePlatform($this->game, $this->platform);
    }

    /**
     *@return GamePlatform A newly created game_platform with given data
     */
    public static function create($game=null, $platform=null){
        $entity = new GamePlatform();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO game_platform (game, platform) VALUES(:game,:platform)", [
			"game" => $game,
			"platform" => $platform
        ]);
    }
}

?>