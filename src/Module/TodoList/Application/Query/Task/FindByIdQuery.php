<?php


namespace App\Module\TodoList\Application\Query\Task;


use App\Core\Message\Query\Query;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use Assert\Assertion;
use Assert\AssertionFailedException;

class FindByIdQuery extends Query
{
    private TaskId $id;

    public function __construct(TaskId $id)
    {
        $this->id = $id;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }


}
