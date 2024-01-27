<?php namespace App\Services;

use App\Entity\Platform;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class PlatformService{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `platform`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data->push(new Platform($data["identifier"], $data["name"], $data["logo"]));
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

    
}

?>