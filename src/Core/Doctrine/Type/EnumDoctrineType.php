<?php


namespace App\Core\Doctrine\Type;


use Acelaya\Doctrine\Type\PhpEnumType;
use App\Core\Doctrine\Type\DoctrineType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class EnumDoctrineType extends PhpEnumType implements DoctrineType
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        $values = \call_user_func([$this->enumClass, 'toArray']);
        return \sprintf(
            'ENUM("%s") COMMENT "%s"',
            \implode('", "', $values),
            $this->getName()
        );
    }
}
