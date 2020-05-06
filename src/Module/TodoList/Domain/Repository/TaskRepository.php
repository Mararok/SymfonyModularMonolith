<?php


namespace App\Module\TodoList\Domain\Repository;


use App\Module\TodoList\Domain\Entity\Task;

interface TaskRepository
{
    public function create(Task $task): void;
    public function findAll(): \Iterator;
    public function findById(int $id): ?Task;
}
