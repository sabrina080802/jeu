<?php namespace App\Services;

use App\Entity\AuthToken;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class AuthTokenService{
    public abstract function getAll():ArrayExtension;
    public abstract function deleteAll():void;
    
}

?>