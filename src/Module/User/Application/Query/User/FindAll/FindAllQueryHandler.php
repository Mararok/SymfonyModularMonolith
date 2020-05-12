<?php


namespace App\Module\User\Application\Query\User\FindAll;


use App\Core\Message\Query\QueryHandler;
use App\Module\User\Domain\Repository\UserRepository;


class FindAllQueryHandler implements QueryHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindAllQuery $query): \Iterator
    {
        return $this->repository->findAll();
    }
}
