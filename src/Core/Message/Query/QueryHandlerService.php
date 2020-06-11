<?php


namespace App\Core\Message\Query;


use App\Core\Message\MessageHandlerService;

abstract class QueryHandlerService extends MessageHandlerService implements QueryHandler
{
    private const SUFFIX_LENGTH = 5; // *Query

    protected static function getHandleMethodName(string $typeClass): string
    {
        return "handle" . substr(basename($typeClass), 0, -self::SUFFIX_LENGTH);
    }
}
