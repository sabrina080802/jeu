<?php namespace App\Services;

use App\Entity\GamePlatform;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

class GamePlatformService{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `game_platform`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data[$i] = new GamePlatform($data[$i]["game"], $data[$i]["platform"]);
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

    
}

?>