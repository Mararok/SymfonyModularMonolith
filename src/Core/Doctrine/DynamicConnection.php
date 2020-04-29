<?php


namespace App\Core\Doctrine;


use Closure;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

class DynamicConnection extends Connection
{
    private string $connectionId;
    private Closure $internalParamsChanger;

    public function __construct(
        array $params,
        Driver $driver,
        ?Configuration $config = null,
        ?EventManager $eventManager = null
    )
    {
        parent::__construct($params, $driver, $config, $eventManager);
        $this->connectionId = "";
        $this->params = $params;
        $this->internalParamsChanger = Closure::bind(function (Connection $c, $newParams) {
            foreach ($newParams as $param => $value) {
                $c->params[$param] = $value;
            }
        }, $this, $this);

    }

    public function switchConnection(string $connectionId, array $params): void
    {
        if ($this->connectionId !== $connectionId) {
            $this->close();
            ($this->internalParamsChanger)($this, $params);
        }
    }
}
