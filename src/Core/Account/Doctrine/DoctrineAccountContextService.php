<?php


namespace App\Core\Account\Doctrine;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Account\AccountContextChangeEvent;
use App\Core\Doctrine\DynamicConnection;

class DoctrineAccountContextService implements EventSubscriberInterface
{
    private AccountConnectionParamsProvider $connectionParamsProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(AccountConnectionParamsProvider $connectionParamsProvider, EntityManagerInterface $entityManager)
    {
        $this->connectionParamsProvider = $connectionParamsProvider;
        $this->entityManager = $entityManager;
    }

    public function onAccountContextChange(AccountContextChangeEvent $event): void
    {
        $this->switchAccount($event->getAccountId());
    }

    public function switchAccount(int $accountId): void
    {
        $connection = $this->entityManager->getConnection();

        if ($connection instanceof DynamicConnection) {
            $this->entityManager->flush();
            $this->entityManager->clear();
            $connection->switchConnection($accountId, $this->connectionParamsProvider->get($accountId));
        } else {
            throw new \LogicException("To switch connection to selected account, connection object must be instance of " . DynamicConnection::class);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            AccountContextChangeEvent::class => "onAccountContextChange"
        ];
    }
}
