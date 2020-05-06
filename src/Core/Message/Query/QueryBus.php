<?php


namespace App\Core\Message\Query;


use App\Core\Message\MessageBusBase;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

class QueryBus extends MessageBusBase
{
    /**
     * @param Query $query
     * @return mixed
     * @throws Throwable
     */
    public function handle(Query $query)
    {
        $this->getLogger()->info("Handling query", ["query" => $query]);
        $envelope = $this->dispatchInMessenger($query);
        /** @var HandledStamp $stamp */
        $stamp = $envelope->last(HandledStamp::class);
        return $stamp->getResult();
    }
}
