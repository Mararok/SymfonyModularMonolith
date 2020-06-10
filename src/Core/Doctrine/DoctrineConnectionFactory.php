<?php


namespace App\Core\Doctrine;


use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\DBAL\Types\Type;

class DoctrineConnectionFactory extends ConnectionFactory
{
    public function __construct(array $typesConfig, string $modulesConfigPath)
    {
        parent::__construct($typesConfig);
        $this->registerModulesTypes($modulesConfigPath);
    }

    private function registerModulesTypes($modulesConfigPath)
    {
        foreach (ModularDoctrineConfigLoader::loadModuleConfigs($modulesConfigPath) as $moduleId => $config) {
            $this->registerModuleEnumTypes($config);
            $this->registerModuleCustomTypes($config);
        }
    }

    private function registerModuleEnumTypes(array $config)
    {
        if (isset($config["enumTypes"])) {
            foreach ($config["enumTypes"] as $name => $typeClass) {
                if (!DoctrineEnumType::hasType($typeClass)) {
                    DoctrineEnumType::registerEnumType($typeClass);
                }
            }
        }
    }

    private function registerModuleCustomTypes(array $config)
    {
        if (isset($config["customTypes"])) {
            foreach ($config["customTypes"] as $name => $class) {
                if (!Type::hasType($name)) {
                    Type::addType($name, $class);
                }
            }
        }
    }

}
