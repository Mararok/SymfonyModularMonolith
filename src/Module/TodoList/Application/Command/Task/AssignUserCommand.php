<?php


namespace App\Module\TodoList\Application\Command\Task;


use App\Core\Message\Command\Command;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class AssignUserCommand extends Command
{
    private TaskId $taskId;
    private UserId $userId;

    public function __construct(TaskId $taskId, UserId $userId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function getTaskId(): TaskId
    {
        return $this->taskId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
