<?php


namespace App\Core\Account;


use Symfony\Contracts\EventDispatcher\Event;

class AccountContextChangeEvent extends Event
{
    private int $accountId;

    public function __construct(int $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }
}
