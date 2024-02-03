<?php

namespace App\Services;

use App\Entity\Account;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

class AccountService
{
	public static function getAll():ArrayExtension
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->query("SELECT * FROM `account`;", []);
		for($i = 0;$i < $data->count();$i++){
			$data[$i] = new Account($data[$i]["identifier"], $data[$i]["email"], $data[$i]["pass"], $data[$i]["pseudo"], $data[$i]["creation_date"]);
		}
		return $data;
	}

	public static function deleteAll():void
	{
		$db = DbManager::getDatabase('crossplayarena');

	}

	public static function getBy($identifier):Account|null
	{
		$db = DbManager::getDatabase('crossplayarena');
		$data = $db->first("SELECT * FROM `account` WHERE identifier = :identifier;", [
			"identifier" => $identifier,
		]);
		return $data == null ? null : new Account($data["identifier"], $data["email"], $data["pass"], $data["pseudo"], $data["creation_date"]);
	}

}
