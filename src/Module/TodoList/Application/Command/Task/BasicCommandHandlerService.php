<?php


namespace App\Module\TodoList\Application\Command\Task;


use App\Core\Domain\Exception\NotFoundException;
use App\Core\Message\Command\CommandHandler;
use App\Core\Message\Command\CommandHandlerService;
use App\Core\Message\Event\EventBus;
use App\Core\Message\Query\QueryBus;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Event\TaskCreatedEvent;
use App\Module\TodoList\Domain\Event\UserAssignedEvent;
use App\Module\TodoList\Domain\Repository\TaskRepository;
use App\Module\User\Application\Query\User\ExistsQuery;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class BasicCommandHandlerService extends CommandHandlerService
{
    private TaskRepository $repository;
    private EventBus $eventBus;
    private QueryBus $queryBus;

    public function __construct(TaskRepository $repository, EventBus $eventBus, QueryBus $queryBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
        $this->queryBus = $queryBus;
    }

    public function handleCreate(CreateCommand $command): void
    {
        $entity = Task::createNew($command->getName());
        $this->repository->saveOrUpdate($entity);
        $this->eventBus->handle(new TaskCreatedEvent($entity->getId()));
    }

    public function handleAssignUser(AssignUserCommand $command)
    {
        $task = $this->repository->getById($command->getTaskId());

        if ($task->getAssignedUserId()->equals($command->getUserId())) {
            return;
        }

        if (!$this->isUserExists($command->getUserId())) {
            throw new NotFoundException("User entity not found");
        }

        $task->setAssignedUserId($command->getUserId());
        $this->repository->saveOrUpdate($task);
        $this->eventBus->handle(new UserAssignedEvent($command->getUserId(), $command->getTaskId()));
    }

    private function isUserExists(UserId $userId): bool
    {
        return $this->queryBus->handle(new ExistsQuery($userId));
    }

    protected static function getSupportedTypes(): array
    {
        return [
            CreateCommand::class,
            AssignUserCommand::class
        ];
    }
}
