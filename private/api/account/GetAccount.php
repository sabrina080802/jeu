<?php

namespace App\API\Account;

use App\Services\AccountService;
use Magy\Utils\REST;
use Magy\Managers\DbManager;

class GetAccount extends REST
{
    private $account;

    public function getParams()
    {
        return [
            'id' => REST::INT
        ];
    }
    public function process($data)
    {
        $this->account = AccountService::getBy(5);
    }
    public function getResponse()
    {
        return $this->account;
    }
}
