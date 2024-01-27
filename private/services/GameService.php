<?php namespace App\Services;

use App\Entity\Game;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class GameService{
    public abstract function getAll():ArrayExtension;
    public abstract function deleteAll():void;
    
}

?>