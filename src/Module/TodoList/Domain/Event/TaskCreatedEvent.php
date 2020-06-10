<?php


namespace App\Module\TodoList\Domain\Event;


use App\Core\Message\Event\Event;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;

class TaskCreatedEvent extends Event
{
    private TaskId $taskId;

    public function __construct(TaskId $taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): TaskId
    {
        return $this->taskId;
    }
}
