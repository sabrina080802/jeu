<?php namespace App\Services;

use App\Entity\Game;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

class GameService{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `game`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data[$i] = new Game($data[$i]["identifier"], $data[$i]["name"]);
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

    
}

?>