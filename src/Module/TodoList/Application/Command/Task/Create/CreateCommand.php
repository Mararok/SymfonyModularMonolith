<?php


namespace App\Module\TodoList\Application\Command\Task\CreateTask;


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
