<?php


namespace App\Module\TodoList\Infrastructure\Persistence;


use App\Module\TodoList\Domain\TodoListItem;
use App\Module\TodoList\Domain\TodoListItemStatus;

class InMemoryTodoListItemRepositoryFactory
{
    public function __invoke()
    {
        return new InMemoryTodoListItemRepository([
            new TodoListItem(1, new \DateTimeImmutable(), TodoListItemStatus::TODO(), "task_1"),
            new TodoListItem(2, new \DateTimeImmutable(), TodoListItemStatus::IN_PROGRESS(), "task_2"),
            new TodoListItem(3, new \DateTimeImmutable(), TodoListItemStatus::TODO(), "task_3"),
        ]);
    }
}
