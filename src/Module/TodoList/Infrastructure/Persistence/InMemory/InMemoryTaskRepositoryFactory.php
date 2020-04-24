<?php


namespace App\Module\TodoList\Infrastructure\Persistence\InMemory;


use App\Module\TodoList\Domain\Task;
use App\Module\TodoList\Domain\TaskStatus;

class InMemoryTaskRepositoryFactory
{
    public function __invoke()
    {
        return new InMemoryTaskRepository([
            new Task(1, "task_1", new \DateTimeImmutable(), TaskStatus::TODO()),
            new Task(2, "task_2", new \DateTimeImmutable(), TaskStatus::IN_PROGRESS()),
            new Task(3, "task_3", new \DateTimeImmutable(), TaskStatus::TODO()),
        ]);
    }
}
