<?php

namespace App\Entity;

class AuthToken
{
    public $account;
    public $identifier;
    public $token;

    public function __construct($account = null, $identifier = null, $token = null)
    {
        $this->account = $account;
        $this->identifier = $identifier;
        $this->token = $token;
    }

    /**
     * Delete the record in database using primary keys
     */
    public function delete()
    {
        DbManager::getDatabase('crossplayarena')
            ->execute('DELETE FROM auth_token WHERE ');
    }

    /**
     * Update the record in database with entity data
     */
    public function flush()
    {
    }

    /**
     *@return AuthToken A newly created auth_token with given data
     */
    public static function create($account = null, $identifier = null, $token = null)
    {
        $entity = new AuthToken();
        $db = DbManager::getDatabase('crossplayarena');
        $db->insert("INSERT INTO auth_token (account, identifier, token) VALUES(:account,:identifier,:token)", [
            "account" => $account,
            "identifier" => $identifier,
            "token" => $token
        ]);
    }
}
