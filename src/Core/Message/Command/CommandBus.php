<?php


namespace App\Core\Message\Command;


use App\Core\Message\MessageBusBase;
use Throwable;

class CommandBus extends MessageBusBase
{
    /**
     * @param Command $command
     * @throws Throwable
     */
    public function handle(Command $command): void
    {
        $this->dispatchInMessenger($command);
    }
}
