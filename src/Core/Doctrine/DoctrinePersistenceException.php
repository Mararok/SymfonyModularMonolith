<?php


namespace App\Core\Doctrine;


use App\Core\Domain\Exception\PersistenceException;
use Throwable;

/**
 * Wrapper class for all doctrine exceptions
 */
class DoctrinePersistenceException extends PersistenceException
{
    public static function createFromDoctrine(Throwable $previous = null)
    {
        return new self($previous->getMessage(), 500, $previous);
    }

    public static function create(string $message, Throwable $previous = null): self
    {
        return new self($message, 500, $previous);
    }

    private function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
