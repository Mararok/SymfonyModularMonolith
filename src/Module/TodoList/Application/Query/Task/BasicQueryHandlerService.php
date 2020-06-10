<?php


namespace App\Module\TodoList\Application\Query\Task;


use App\Core\Message\Query\QueryHandlerService;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Repository\TaskRepository;

class BasicQueryHandlerService extends QueryHandlerService
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleGetList(GetListQuery $query): \Iterator
    {
        return $this->repository->getList();
    }

    public function handleFindById(FindByIdQuery $query): Task
    {
        return $this->repository->getById($query->getId());
    }

    protected static function getSupportedTypes(): array
    {
        return [
            GetListQuery::class,
            FindByIdQuery::class
        ];
    }
}
