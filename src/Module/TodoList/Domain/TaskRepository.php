<?php


namespace App\Module\TodoList\Domain;


interface TaskRepository
{
    public function create(Task $task): void;
    public function findAll(): \Iterator;
    public function findById(int $id): ?Task;
}
