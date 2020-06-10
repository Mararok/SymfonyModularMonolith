<?php


namespace App\Core\Message;


use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

abstract class MessageHandlerService implements MessageSubscriberInterface
{
    protected static abstract function getSupportedTypes(): array;

    public static function getHandledMessages(): iterable
    {
        foreach (static::getSupportedTypes() as $typeClass) {
            yield $typeClass => [
                "method" => static::getHandleMethodName($typeClass),
            ];
        }
    }

    protected abstract static function getHandleMethodName(string $typeClass): string;
}
