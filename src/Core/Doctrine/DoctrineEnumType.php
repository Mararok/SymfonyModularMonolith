<?php


namespace App\Core\Doctrine;


use Acelaya\Doctrine\Type\PhpEnumType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class DoctrineEnumType extends PhpEnumType
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
