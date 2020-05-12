<?php


namespace App\Core\Domain\Exception;


class NotFoundException extends DomainException
{
    public static function create()
    {
        return new self("Resource not found");
    }
}
