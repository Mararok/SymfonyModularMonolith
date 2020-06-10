<?php


namespace App\Module\User\Application\Command\User\SendNotification;


use App\Core\Message\Command\CommandBus;
use App\Core\Message\Command\CommandHandler;
use App\Core\Message\Query\QueryBus;
use App\Module\Email\Application\Command\SendTemplatedEmail\SendTemplatedEmailCommand;
use App\Module\User\Application\Query\User\GetByIdQuery;
use App\Module\User\Domain\Entity\User;

class SendEmailNotificationCommandHandler implements CommandHandler
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function __invoke(SendEmailNotificationCommand $command)
    {
        /** @var User $user */
        $user = $this->queryBus->handle(new GetByIdQuery($command->getTo()));
        $this->commandBus->handle(new SendTemplatedEmailCommand(
            $command->getFrom(),
            $user->getEmail(),
            $command->getContent()->extendContextWith([
                "user" => [
                    "name" => $user->getName()
                ]
            ])
        ));
    }
}
