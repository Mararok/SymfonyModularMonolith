<?php


namespace App\Module\User\Application\Query\User;


use App\Core\Message\Query\QueryHandlerService;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class BasicQueryHandlerService extends QueryHandlerService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleGetList(GetListQuery $query): \Iterator
    {
        return $this->repository->getList();
    }

    public function handleGetById(GetByIdQuery $query): User
    {
        return $this->repository->getById($query->getId());
    }

    public function handleExists(ExistsQuery $query): bool
    {
        return $this->repository->exists($query->getId());
    }

    protected static function getSupportedTypes(): array
    {
        return [
            GetListQuery::class,
            GetByIdQuery::class,
            ExistsQuery::class
        ];
    }
}
