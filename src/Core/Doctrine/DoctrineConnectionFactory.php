<?php


namespace App\Core\Doctrine;


use App\Core\Doctrine\Type\EnumDoctrineType;
use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\DBAL\Types\Type;

class DoctrineConnectionFactory extends ConnectionFactory
{
    private const TYPE_SUFFIX_LENGTH = 12; // *DoctrineType

    public function __construct(array $typesConfig, string $modulesConfigPath)
    {
        parent::__construct($typesConfig);
        $this->registerModulesTypes($modulesConfigPath);
    }

    private function registerModulesTypes($modulesConfigPath)
    {
        foreach (ModularDoctrineConfigLoader::loadModuleConfigs($modulesConfigPath) as $moduleId => $config) {
            $this->registerModuleEnumTypes($moduleId, $config);
            $this->registerModuleCustomTypes($moduleId, $config);
        }
    }

    private function registerModuleEnumTypes(string $moduleId, array $config)
    {
        if (isset($config["enumTypes"])) {
            foreach ($config["enumTypes"] as $typeClass) {
                $typeName = self::createTypeName($moduleId, basename($typeClass));
                if (!EnumDoctrineType::hasType($typeName)) {
                    EnumDoctrineType::registerEnumType($typeName, $typeClass);
                }
            }
        }
    }

    private function registerModuleCustomTypes(string $moduleId, array $config)
    {
        if (isset($config["customTypes"])) {
            foreach ($config["customTypes"] as $typeClass) {
                $typeName = self::createTypeName($moduleId, substr(basename($typeClass), 0, -self::TYPE_SUFFIX_LENGTH));
                if (!Type::hasType($typeName)) {
                    Type::addType($typeName, $typeClass);
                }
            }
        }
    }

    private static function createTypeName(string $moduleId, string $baseTypeName): string
    {
        return "$moduleId.$baseTypeName";
    }

}
