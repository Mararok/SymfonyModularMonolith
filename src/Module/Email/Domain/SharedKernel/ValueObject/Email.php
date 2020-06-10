<?php


namespace App\Module\Email\Domain\SharedKernel\ValueObject;


use Assert\Assertion;

class Email implements \JsonSerializable
{
    private string $value;

    public function __construct(string $value)
    {
        Assertion::email($value);
        $this->value = $value;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function getRaw(): string
    {
        return $this->value;
    }

    public function getLocalPart(): string
    {
        return $this->getParts()[0];
    }

    public function getDomain(): string
    {
        return $this->getParts()[1];
    }

    public function getParts(): array
    {
        return explode("@", $this->value, 2);
    }

    public function jsonSerialize()
    {
        return $this->getRaw();
    }

    public function __toString()
    {
        return $this->value;
    }
}
