<?php namespace App\Services;

use App\Entity\GamePlatform;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class GamePlatformService{
    public abstract function getAll():ArrayExtension;
    public abstract function deleteAll():void;
    
}

?>