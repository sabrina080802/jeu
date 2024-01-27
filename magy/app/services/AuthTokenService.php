<?php namespace App\Services;

use App\Entity\AuthToken;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class AuthTokenService{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `auth_token`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data->push(new AuthToken($data["identifier"], $data["token"], $data["account"]));
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

    
}

?>