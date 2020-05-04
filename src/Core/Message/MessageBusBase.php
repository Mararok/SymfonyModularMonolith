<?php


namespace App\Core\Message;


use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

abstract class MessageBusBase
{
    private MessageBusInterface $messengerBus;

    public function __construct(MessageBusInterface $messengerBus)
    {
        $this->messengerBus = $messengerBus;
    }

    /**
     * @param object $message
     * @return Envelope
     * @throws Throwable
     */
    protected function dispatchInMessenger(object $message): Envelope
    {
        try {
            return $this->messengerBus->dispatch($message);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }

    /**
     * @param HandlerFailedException $exception
     * @throws Throwable
     */
    private function throwException(HandlerFailedException $exception): void
    {
        while ($exception instanceof HandlerFailedException) {
            $exception = $exception->getPrevious();
        }

        throw $exception;
    }
}
