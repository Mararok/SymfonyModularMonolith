<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\Type\IntIdDoctrineType;
use App\Core\Domain\IntValue;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class TaskIdDoctrineType extends IntIdDoctrineType
{
    public const NAME = "TodoList.TaskId";

    protected function createFromValue(int $value): IntValue
    {
        return TaskId::create($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}
