<?php


namespace App\Module\User\Application\Command\User\Create;


use App\Core\Message\Command\Command;

class CreateCommand implements Command
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
