<?php


namespace App\Core\Rest\Controller;


use App\Core\Message\Command\Command;
use App\Core\Message\Command\CommandBus;
use App\Core\Message\Query\QueryBus;

abstract class CommandQueryController extends QueryController
{
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        parent::__construct($queryBus);
        $this->commandBus = $commandBus;
    }

    protected function executeCommand(Command $command): void
    {
        $this->commandBus->handle($command);
    }
}
