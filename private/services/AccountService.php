<?php namespace App\Services;

use App\Entity\Account;
use Magy\Utils\ArrayExtension;

abstract class AccountService{
    public abstract function getAll():ArrayExtension;
    
}

?>