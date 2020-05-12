<?php


namespace App\Module\User\Application\Query\User\FindById;


use App\Core\Message\Query\QueryHandler;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class FindByIdQueryHandler implements QueryHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindByIdQuery $query): User
    {
        return $this->repository->findById($query->getId());
    }
}
