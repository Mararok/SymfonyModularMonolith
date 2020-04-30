<?php


namespace App\Core\Account\Doctrine;


use App\Core\Doctrine\DynamicConnection;
use Doctrine\ORM\EntityManagerInterface;

class AccountConnectionContextService
{
    private AccountConnectionParamsProvider $connectionParamsProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(AccountConnectionParamsProvider $connectionParamsProvider, EntityManagerInterface $entityManager)
    {
        $this->connectionParamsProvider = $connectionParamsProvider;
        $this->entityManager = $entityManager;
    }


    public function switchConnection(string $accountId)
    {
        $connection = $this->entityManager->getConnection();

        if ($connection instanceof DynamicConnection) {
            $this->entityManager->flush();
            $this->entityManager->clear();
            $connection->switchConnection($accountId, $this->connectionParamsProvider->get($accountId));
        } else {
            throw new \LogicException("To switch connection to selected account, connection object must be instance of ".DynamicConnection::class);
        }
    }
}
