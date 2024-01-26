<?php

namespace App\API\Account;

use Magy\Utils\REST;
use Magy\Managers\DbManager;
use App\Entity\Account;


//Requête pour s'inscrite
class Register extends REST
{
    private Account $account;
    private $success;
    private $error;

    private $message;

    //Définir les paramètres de la requête
    public function getParams()
    {
        return [
            'pseudo' => REST::TEXT,
            'email' => REST::TEXT,
            'pass' => REST::TEXT
        ];
    }

    //Corps de la requête
    public function process($data)
    {
        $db = DbManager::getDatabase('crossplayarena');
        // Vérifier si le compte existe déjà
        $existingAccount = $db->first('SELECT * FROM account WHERE email = :email;', $data);

        if (!$existingAccount) {
            $data->pass = password_hash($data->pass, PASSWORD_BCRYPT);
            // Le compte n'existe pas, procéder à l'insertion

            $this->account = Account::create(null, $data->email, $data->pass, $data->pseudo);
            //$db->query('INSERT INTO account (email, pass, pseudo) VALUES(:email, :pass, :pseudo);', $data);
            // Récupérer les données du compte nouvellement inséré
            $this->account = $db->first('SELECT * FROM account WHERE email = :email AND pass = :pass', $data);

            $this->success = true;
        } else {
            // Le compte existe déjà, envoyer une réponse JSON indiquant l'échec
            $this->success = false;
            $this->error = "Le compte avec cet email existe déjà.";
        }
    }

    //Résultat de la requête
    public function getResponse()
    {
        return (object)[
            'success' => $this->success,
            'error' => $this->error
        ];
    }
}
