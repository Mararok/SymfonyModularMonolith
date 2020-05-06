<?php


namespace App\Core\Message\Command;


use App\Core\Message\MessageBusBase;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class CommandBus extends MessageBusBase
{
    /**
     * @param Command $command
     * @throws Throwable
     */
    public function handle(Command $command): void
    {
        $this->getLogger()->info("Handling command", ["command" => $command]);
        $this->dispatchInMessenger($command);
    }
}
