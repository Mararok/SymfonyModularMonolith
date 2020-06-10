<?php


namespace App\Core\Domain;


abstract class IntValue implements \JsonSerializable
{
    private int $value;

    protected function __construct(int $value)
    {
        $this->value = $value;
    }

    public abstract function isEmpty(): bool;

    public function getRaw(): int
    {
        return $this->value;
    }

    public function equals(IntValue $other): bool
    {
        return $this->getRaw() === $other->getRaw();
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
