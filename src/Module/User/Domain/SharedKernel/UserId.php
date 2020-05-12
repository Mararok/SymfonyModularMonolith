<?php


namespace App\Module\User\Domain\SharedKernel;


use Assert\Assertion;

class UserId implements \JsonSerializable
{
    private static UserId $empty;

    private int $id;

    private function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        Assertion::min($id, 1);
        return new self($id);
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

    public function getRaw(): int
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return $this->getRaw();
    }

    public function __toString()
    {
        return (string)$this->getRaw();
    }
}
