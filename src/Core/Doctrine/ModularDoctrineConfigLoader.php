<?php


namespace App\Core\Doctrine;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ModularDoctrineConfigLoader
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
        $moduleConfigs = self::loadModuleConfigs($this->modulesConfigPath);
        $this->container->loadFromExtension('doctrine', $this->generateDoctrineConfig($moduleConfigs));
    }

    private function generateDoctrineConfig(array $moduleConfigs): array
    {
        $systemModulesMappings = [];
        $accountModulesMappings = [];
        foreach ($moduleConfigs as $moduleName => $moduleConfig) {
            $mapping = $this->generateModuleMapping($moduleName);
            if ($moduleConfig['isAccountModule']) {
                $accountModulesMappings[$moduleName] = $mapping;
            } else {
                $systemModulesMappings[$moduleName] = $mapping;
            }
        }

        return [
            'dbal' => [
                'default_connection' => 'system',
                'connections' => [
                    'system' => [ // @TODO change to env
                        'dbname' => 'system',
                        'port' => '10003',
                        'user' => 'root',
                        'password' => 'test',
                        'driver' => 'pdo_mysql',
                        'server_version' => '5.7',
                        'charset' => 'utf8mb4',

                    ],
                    'account' => [ // dynamic
                        'port' => '10003',
                        'user' => 'root',
                        'password' => 'test',
                        'driver' => 'pdo_mysql',
                        'server_version' => '5.7',
                        'charset' => 'utf8mb4',
                        'wrapper_class' => DynamicConnection::class,
                    ]
                ],
            ],
            'orm' => [
                'default_entity_manager' => 'system',
                'entity_managers' => [
                    'system' => [
                        'connection' => 'system',
                        'mappings' => $systemModulesMappings,
                    ],
                    'account' => [
                        'connection' => 'account',
                        'mappings' => $accountModulesMappings
                    ],
                ],
            ],
        ];
    }

    public static function loadModuleConfigs(string $modulesConfigPath): array
    {
        $finder = new Finder();
        $finder->files()->name('doctrine.php');

        $modules = [];
        /** @var SplFileInfo $moduleConfigFile */
        foreach ($finder->in($modulesConfigPath) as $moduleConfigFile) {
            $moduleName = basename($moduleConfigFile->getPath());
            $modules[$moduleName] = include($moduleConfigFile->getPathname());
        }
        return $modules;
    }

    private function generateModuleMapping(string $moduleName): array
    {
        return [
            'type' => 'xml',
            'dir' => '%kernel.project_dir%/src/Module/' . $moduleName . '/Infrastructure/Persistence/Doctrine',
            'is_bundle' => false,
            'prefix' => 'App\\Module\\' . $moduleName . '\\Domain\\Entity',
            'alias' => $moduleName,
        ];
    }


}
