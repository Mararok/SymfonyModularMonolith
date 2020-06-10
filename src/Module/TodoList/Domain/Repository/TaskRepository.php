<?php


namespace App\Module\TodoList\Domain\Repository;


use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;

interface TaskRepository
{
    public function saveOrUpdate(Task $task): void;

    public function getById(TaskId $id): Task;

    public function getList(): \Iterator;

    public function delete(Task $task): void;
}
