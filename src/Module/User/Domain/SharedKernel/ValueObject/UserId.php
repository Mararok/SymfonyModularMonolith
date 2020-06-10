<?php


namespace App\Module\User\Domain\SharedKernel\ValueObject;


use App\Core\Domain\IntValue;
use Assert\Assertion;

class UserId extends IntValue
{
    private static self $empty;

    public static function create(int $id): self
    {
        Assertion::min($id, 1);
        return new static($id);
    }

    public static function emptyValue(): self
    {
        if (!isset(self::$empty)) {
            self::$empty = new self(0);
        }

        return self::$empty;
    }

    public function isEmpty(): bool
    {
        return $this === self::emptyValue();
    }
}
