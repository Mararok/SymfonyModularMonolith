<?php


namespace App\Module\User\Application\Command\User\Create;


use App\Core\Message\Command\CommandHandler;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class CreateCommandHandler implements CommandHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCommand $command): void
    {
        $entity = User::createNew($command->getName());
        $this->repository->create($entity);
    }
}
