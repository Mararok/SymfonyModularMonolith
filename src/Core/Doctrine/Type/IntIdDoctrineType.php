<?php


namespace App\Core\Doctrine\Type;


use App\Core\Domain\IntValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

abstract class IntIdDoctrineType extends IntegerType implements DoctrineType
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL(array_merge([
            "unsigned" => true
        ], $fieldDeclaration));
    }

    /**
     * @param int $value
     * @param AbstractPlatform $platform
     * @return IntValue
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $this->createFromValue($value);
    }

    protected abstract function createFromValue(int $value): IntValue;

    /**
     * @param IntValue $value
     * @param AbstractPlatform $platform
     * @return int
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getRaw();
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
