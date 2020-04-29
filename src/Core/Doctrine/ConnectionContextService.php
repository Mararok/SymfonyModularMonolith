<?php


namespace App\Core\Doctrine;


use Doctrine\ORM\EntityManagerInterface;

class ConnectionContextService
{
    private ConnectionParamsProvider $connectionParamsProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(ConnectionParamsProvider $connectionParamsProvider, EntityManagerInterface $entityManager)
    {
        $this->connectionParamsProvider = $connectionParamsProvider;
        $this->entityManager = $entityManager;
    }

    public function switchConnection(string $connectionId)
    {
        $connection = $this->entityManager->getConnection();
        if ($connection instanceof ConnectionWrapper) {
            $connection->switchConnection($connectionId, $this->connectionParamsProvider->get($connectionId));
        }
    }
}
