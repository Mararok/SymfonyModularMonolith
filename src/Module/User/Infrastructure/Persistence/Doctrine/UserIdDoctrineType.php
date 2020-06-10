<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\Type\IntIdDoctrineType;
use App\Core\Domain\IntValue;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class UserIdDoctrineType extends IntIdDoctrineType
{
    public const NAME = "User.UserId";

    protected function createFromValue(int $value): IntValue
    {
        return $value === 0 ? UserId::emptyValue() : UserId::create($value);
    }

    public function getName()
    {
        return self::NAME;
    }
}
