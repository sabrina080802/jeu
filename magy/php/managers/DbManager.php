<?php

namespace Magy\Managers;

use Magy\Database\Database;

class DbManager
{
    private static $databases = [];

    /**
     * Get a database by its name
     * @param string $name the db name
     * @return Database
     */
    public static function getDatabase(string $name): Database
    {
        if (isset(self::$databases[$name]) == false) {
            include CONFIG_PATH . 'Databases/' . $name . '.php';
        }

        return self::$databases[$name];
    }
    /**
     * For config only.
     * @param string $host IP address of your database
     * @param string $name Your Db name
     * @param string $user Your Db user name
     * @param string $password Your password user name
     * @param array $options Given options to PDO
     */
    public static function createDatabase(string $host, string $name, string $user, string $password, array $options = []): void
    {
        if (isset(self::$databases[$name])) {
            return;
        }

        $db = new Database($host, $name, $user, $password, $options);
        self::$databases[$name] = $db;
    }
}
