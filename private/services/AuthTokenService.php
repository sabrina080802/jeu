<?php

namespace App\Services;

use App\Entity\AuthToken;
use Magy\Utils\ArrayExtension;

abstract class AuthTokenService
{
    public abstract function getAll(): ArrayExtension;
}
