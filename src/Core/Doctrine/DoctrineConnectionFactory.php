<?php


namespace App\Core\Doctrine;


use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;

class DoctrineConnectionFactory extends ConnectionFactory
{
    public function __construct(array $typesConfig, string $modulesConfigPath)
    {
        parent::__construct($typesConfig);
        $this->registerModulesEnumTypes($modulesConfigPath);
    }

    private function registerModulesEnumTypes($modulesConfigPath)
    {
        foreach (ModularDoctrineConfigLoader::loadModuleConfigs($modulesConfigPath) as $moduleId => $config) {
            foreach ($config["enumTypes"] as $enumTypeClass) {
                if (!DoctrineEnumType::hasType($enumTypeClass)) {
                    DoctrineEnumType::registerEnumType($enumTypeClass);
                }
            }
        }
    }

}
