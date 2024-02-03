<?php

namespace App\Entity;

use Magy\Managers\DbManager;

class Game
{
    public $identifier;
    public $name;

    public function __construct($identifier = null, $name = null)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete()
    {
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM game WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush()
    {
    }

    public function copy(): Game
    {
        return new Game($this->identifier, $this->name);
    }

    /**
     *@return Game A newly created game with given data
     */
    public static function create($identifier = null, $name = null)
    {
        $entity = new Game();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO game (identifier, name) VALUES(:identifier,:name)", [
            "identifier" => $identifier,
            "name" => $name
        ]);
    }
}
