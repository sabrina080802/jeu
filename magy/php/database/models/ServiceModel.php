<?php namespace App\Services;

use App\Entity\{{EntityName}};
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class {{EntityName}}Service{
    public abstract function getAll():ArrayExtension;
    public abstract function deleteAll():void;
    
}

?>