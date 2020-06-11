<?php


namespace App\Core\Message\Event;


use App\Core\Message\Command\CommandHandler;
use App\Core\Message\MessageHandlerService;

abstract class EventHandlerService extends MessageHandlerService implements EventHandler
{
    private const TYPE_SUFFIX_LENGTH = 5; // *Event

    protected static function getHandleMethodName(string $typeClass): string
    {
        return "handle" . substr(basename($typeClass), 0, -self::TYPE_SUFFIX_LENGTH);
    }
}
