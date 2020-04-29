<?php


namespace App\Core\Tenant\Doctrine;


use App\Core\Doctrine\DoctrineEnumType;
use App\Core\Doctrine\DynamicConnection;
use App\Core\Doctrine\ModularDoctrineConfigLoader;
use App\Module\TodoList\Domain\TaskStatus;
use Doctrine\ORM\EntityManagerInterface;

class TenantConnectionContextService
{
    private TenantConnectionParamsProvider $connectionParamsProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(TenantConnectionParamsProvider $connectionParamsProvider, EntityManagerInterface $entityManager)
    {
        $this->connectionParamsProvider = $connectionParamsProvider;
        $this->entityManager = $entityManager;
    }


    public function switchConnection(string $tenantId)
    {
        $connection = $this->entityManager->getConnection();

        if ($connection instanceof DynamicConnection) {
            $connection->switchConnection($tenantId, $this->connectionParamsProvider->get($tenantId));
        } else {
            throw new \LogicException("To switch connection to selected tenant, connection object must be instance of ".DynamicConnection::class);
        }
    }
}
