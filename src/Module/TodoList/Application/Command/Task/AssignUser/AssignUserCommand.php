<?php


namespace App\Module\TodoList\Application\Command\Task\AssignUser;


use App\Core\Message\Command\Command;
use App\Module\User\Domain\SharedKernel\UserId;

class AssignUserCommand implements Command
{
    private UserId $userId;

    private int $taskId;

    public function __construct(UserId $userId, int $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }
}
