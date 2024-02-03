<?php namespace App\Services;

use App\Entity\AuthToken;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

class AuthTokenService{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `auth_token`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data[$i] = new AuthToken($data[$i]["identifier"], $data[$i]["token"], $data[$i]["account"]);
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

    
}

?>