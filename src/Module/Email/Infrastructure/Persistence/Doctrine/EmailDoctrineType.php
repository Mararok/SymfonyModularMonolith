<?php


namespace App\Module\Email\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\Type\DoctrineType;
use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class EmailDoctrineType extends StringType
{
    public const NAME = "Email.Email";

    public function getDefaultLength(AbstractPlatform $platform)
    {
        return 255;
    }

    /**
     * @param string $value
     * @param AbstractPlatform $platform
     * @return Email
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Email::create($value);
    }

    /**
     * @param Email $value
     * @param AbstractPlatform $platform
     * @return string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getRaw();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return self::NAME;
    }
}
