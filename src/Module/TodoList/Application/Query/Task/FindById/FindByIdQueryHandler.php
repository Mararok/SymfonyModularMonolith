<?php


namespace App\Module\TodoList\Application\Query\Task\FindById;


use App\Core\Message\Query\QueryHandler;
use App\Module\TodoList\Domain\Task;
use App\Module\TodoList\Domain\TaskRepository;

class FindByIdQueryHandler implements QueryHandler
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindByIdQuery $query): ?Task
    {
        return $this->repository->findById($query->getId());
    }
}
