<?php


namespace App\Core\Message\Query;


use App\Core\Message\MessageHandlerService;

abstract class QueryHandlerService extends MessageHandlerService implements QueryHandler
{
    private const TYPE_SUFFIX_LENGTH = 5; // *Query

    protected static function getHandleMethodName(string $typeClass): string
    {
        return "handle" . substr($typeClass, strrpos($typeClass, "\\") + 1, -self::TYPE_SUFFIX_LENGTH);
    }
}
