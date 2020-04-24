<?php


namespace App\Module\TodoList\Application;


use App\Module\TodoList\Domain\Task;
use App\Module\TodoList\Domain\TaskRepository;

class TaskService
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findById(int $id): Task
    {
        return $this->repository->findById($id);
    }

    public function findAll(): \Iterator
    {
        return $this->repository->findAll();
    }
}
