<?php App\Entity;

class GamePlatform{
	public $game;
	public $platform;

    public function __construct($game=null, $platform=null){
		$this->game = $game;
		$this->platform = $platform;
    }
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