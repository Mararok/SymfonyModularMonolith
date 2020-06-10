<?php


namespace App\Module\TodoList\Application\Event\Task;


use App\Core\Message\Command\CommandBus;
use App\Core\Message\Event\EventHandler;
use App\Core\Message\Query\QueryBus;
use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\Email\Domain\SharedKernel\ValueObject\TemplatedEmailContent;
use App\Module\TodoList\Application\Query\Task\FindByIdQuery;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Event\UserAssignedEvent;
use App\Module\User\Application\Command\User\SendNotification\SendEmailNotificationCommand;

class UserAssignedEventHandler implements EventHandler
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;
    private Email $notificationFromEmail;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, $notificationFromEmail)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->notificationFromEmail = $notificationFromEmail;
    }

    public function __invoke(UserAssignedEvent $event): void
    {
        /** @var Task $task */
        $task = $this->queryBus->handle(new FindByIdQuery($event->getTaskId()));

        $this->commandBus->handle(new SendEmailNotificationCommand(
            $this->notificationFromEmail,
            $event->getUserId(),
            TemplatedEmailContent::create("modules/TodoList/AssignedUserToTaskEmailNotification.twig", [
                "task" => [
                    "id" => $task->getId()->getRaw(),
                    "name" => $task->getName()
                ]
            ])
        ));
    }
}
