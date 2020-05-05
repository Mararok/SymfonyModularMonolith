<?php


namespace App\Core\Rest\Controller;


use App\Core\Message\Command\Command;
use App\Core\Message\Command\CommandBus;

abstract class CommandController implements Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    protected function executeCommand(Command $command): void
    {
        $this->commandBus->handle($command);
    }
}
