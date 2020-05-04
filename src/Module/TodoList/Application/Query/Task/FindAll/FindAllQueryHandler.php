<?php


namespace App\Module\TodoList\Application\Query\Task\FindAll;


use App\Core\Message\Query\QueryHandler;
use App\Module\TodoList\Domain\TaskRepository;

class FindAllQueryHandler implements QueryHandler
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllQuery $query): \Iterator
    {
        return $this->repository->findAll();
    }
}
