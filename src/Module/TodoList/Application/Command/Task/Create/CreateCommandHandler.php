<?php


namespace App\Module\TodoList\Application\Command\Task\Create;


use App\Core\Message\Command\CommandHandler;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Repository\TaskRepository;
use App\Module\TodoList\Domain\ValueObject\TaskStatus;

class CreateCommandHandler implements CommandHandler
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateCommand $command): void
    {
        $createdAt = \DateTimeImmutable::createFromFormat("U", time());
        $entity = new Task(0, $command->getName(), $createdAt, TaskStatus::TODO());

        $this->repository->create($entity);
    }
}
