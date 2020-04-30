<?php


namespace App\Core\Account;


use Psr\EventDispatcher\EventDispatcherInterface;

class AccountContextService
{
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function switchAccount(int $accountId)
    {
        $this->dispatcher->dispatch(new AccountContextChangeEvent($accountId));
    }

}
