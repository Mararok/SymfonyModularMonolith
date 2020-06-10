<?php


namespace App\Module\TodoList\Domain\Event;


use App\Core\Message\Event\Event;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class UserAssignedEvent extends Event
{
    private UserId $userId;
    private TaskId $taskId;

    public function __construct(UserId $userId, TaskId $taskId)
    {
        $this->userId = $userId;
        $this->taskId = $taskId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getTaskId(): TaskId
    {
        return $this->taskId;
    }
}
