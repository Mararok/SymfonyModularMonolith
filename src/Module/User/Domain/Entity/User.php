<?php


namespace App\Module\User\Domain\Entity;



use App\Module\User\Domain\SharedKernel\UserId;

class User implements \JsonSerializable
{
    private UserId $id;
    private string $name;

    public function __construct(UserId $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function createNew(string $name): self {
        return new self(UserId::emptyValue(), $name);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
