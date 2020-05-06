<?php


namespace App\Core\Message;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

abstract class MessageBusBase implements LoggerAwareInterface
{
    private MessageBusInterface $messengerBus;
    private LoggerInterface $logger;

    public function __construct(MessageBusInterface $messengerBus)
    {
        $this->messengerBus = $messengerBus;
        $this->logger = new NullLogger();
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

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
