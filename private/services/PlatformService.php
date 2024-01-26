<?php

namespace App\Services;

use App\Entity\Platform;
use Magy\Utils\ArrayExtension;

abstract class PlatformService
{
    public abstract function getAll(): ArrayExtension;
}
