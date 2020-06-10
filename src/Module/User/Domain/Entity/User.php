<?php


namespace App\Module\User\Domain\Entity;


use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class User implements \JsonSerializable
{
    private UserId $id;
    private string $name;
    private Email $email;

    public function __construct(UserId $id, string $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function createNew(string $name, Email $email): self
    {
        return new self(UserId::emptyValue(), $name, $email);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
