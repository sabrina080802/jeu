<?php

namespace App\Services;

use App\Entity\Account;
use Magy\Managers\DbManager;
use Magy\Utils\ArrayExtension;

abstract class AccountService
{
    public abstract function getAll(): ArrayExtension;
    public abstract function deleteAll(): void;

    public abstract function getBy($identifier): Account;
}
