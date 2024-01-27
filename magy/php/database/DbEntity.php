<?php

namespace Magy\Database;

use Magy\Utils\ArrayExtension;

class DbEntity
{
    private static ArrayExtension $data;

    public static function storeCopy($entity)
    {
        if (self::$data == null) {
            self::$data = new ArrayExtension();
        }

        self::$data->push($entity->copy());
    }
}
