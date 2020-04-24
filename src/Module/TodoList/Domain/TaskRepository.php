<?php


namespace App\Module\TodoList\Domain;


interface TaskRepository
{
    public function findAll(): \Iterator;
    public function findById(int $id): ?Task;
}
