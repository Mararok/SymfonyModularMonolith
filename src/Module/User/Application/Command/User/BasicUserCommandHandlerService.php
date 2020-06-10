<?php


namespace App\Module\User\Application\Command\User;


use App\Core\Message\Command\CommandHandlerService;
use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class BasicUserCommandHandlerService extends CommandHandlerService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleCreate(CreateCommand $command): void
    {
        $entity = User::createNew($command->getName(), Email::create($command->getEmail()));
        $this->repository->saveOrUpdate($entity);
    }

    protected static function getSupportedTypes(): array
    {
        return [
            CreateCommand::class
        ];
    }
}
