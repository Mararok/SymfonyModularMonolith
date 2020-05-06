<?php


namespace App\Core\Message\Event;


use App\Core\Message\MessageBusBase;
use Throwable;

class EventBus extends MessageBusBase
{
    /**
     * @param Event $event
     * @throws Throwable
     */
    public function handle(Event $event): void
    {
        $this->getLogger()->info("Handling event", ["event" => $event]);
        $this->dispatchInMessenger($event);
    }
}
