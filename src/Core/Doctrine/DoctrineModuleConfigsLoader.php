<?php


namespace App\Core\Doctrine;


use Acelaya\Doctrine\Type\PhpEnumType;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DoctrineModuleConfigsLoader
{
    private ContainerBuilder $container;
    private string $modulesConfigPath;

    public function __construct(ContainerBuilder $container, string $modulesConfigPath)
    {
        $this->container = $container;
        $this->modulesConfigPath = $modulesConfigPath;
    }

    public function load(): void
    {
        $moduleConfigs = $this->loadModuleConfigs();
        $this->loadModulesTypes($moduleConfigs);
        $moduleMappings = $this->generateModulesMapping(array_keys($moduleConfigs));

        $this->container->loadFromExtension('doctrine', [
            // @TODO more dynamic
            'dbal' => [
                'port' => '10003',
                'user' => 'root',
                'password' => 'test',
                'wrapper_class' => ConnectionWrapper::class,
            ],
            'orm' => [
                'auto_mapping' => true,
                'mappings' => $moduleMappings,
            ],
        ]);
    }

    private function loadModuleConfigs(): array
    {
        $finder = new Finder();
        $finder->files()->name('doctrine.php');

        $modules = [];
        /** @var SplFileInfo $moduleConfigFile */
        foreach ($finder->in($this->modulesConfigPath) as $moduleConfigFile) {
            $moduleName = basename($moduleConfigFile->getPath());
            $modules[$moduleName] = include($moduleConfigFile->getPathname());
        }
        return $modules;
    }

    private function generateModulesMapping(array $moduleNames): array
    {
        $moduleMappings = [];
        foreach ($moduleNames as $moduleName) {
            if (file_exists(dirname(dirname(__DIR__)) . "/src/Module/$moduleName/Infrastructure/Persistence/Doctrine")) {
                $moduleMappings[$moduleName] = [
                    'type' => 'annotation',
                    'dir' => "%kernel.project_dir%/src/Module/$moduleName/Infrastructure/Persistence/Doctrine/Entity",
                    'is_bundle' => false,
                    'prefix' => "App\Module/$moduleName/Infrastructure/Persistence/Doctrine/Entity",
                    'alias' => "$moduleName",
                ];
            }
        }

        return $moduleMappings;
    }

    private function loadModulesTypes(array $moduleConfigs): void
    {
        foreach ($moduleConfigs as $moduleConfig) {
            foreach ($moduleConfig["enumTypes"] as $enumType => $enumTypeClass) {
                if (!PhpEnumType::hasType($enumType)) {
                    PhpEnumType::registerEnumType($enumType, $enumTypeClass);
                }
            }
        }
    }
}
