<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Module\User\Domain\SharedKernel\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UserIdDoctrineType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL([
            "unsigned" => true
        ]);
    }

    /**
     * @param int $value
     * @param AbstractPlatform $platform
     * @return UserId
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return UserId::create($value);
    }

    /**
     * @param UserId $value
     * @param AbstractPlatform $platform
     * @return int
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getRaw();
    }

    public function getName()
    {
        return "User.UserId";
    }
}
