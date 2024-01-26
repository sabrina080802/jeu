<?php

namespace App\Entity;

class Platform
{
    public $identifier;
    public $logo;
    public $name;

    public function __construct($identifier = null, $logo = null, $name = null)
    {
        $this->identifier = $identifier;
        $this->logo = $logo;
        $this->name = $name;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete()
    {
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM platform WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush()
    {
    }

    /**
     *@return Platform A newly created platform with given data
     */
    public static function create($identifier = null, $logo = null, $name = null)
    {
        $entity = new Platform();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO platform (identifier, logo, name) VALUES(:identifier,:logo,:name)", [
            "identifier" => $identifier,
            "logo" => $logo,
            "name" => $name
        ]);
    }
}
