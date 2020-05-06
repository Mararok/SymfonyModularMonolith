<?php


namespace App\Core\Doctrine;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Reference;

class DoctrineDomainRepositoryImplementCompilerPass implements CompilerPassInterface
{
    private const TAG = "app.core.doctrine.domain_repository_implementation";
    private const DOMAIN_REPOSITORY_CLASS_REGEX = '/^App\\\\Module\\\\(?<moduleName>\w+)\\\\Domain\\\\Repository\\\\(?<entityName>\w+)Repository$/';

    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds(self::TAG);
        foreach ($taggedServices as $id => $tags) {
            if (preg_match(self::DOMAIN_REPOSITORY_CLASS_REGEX, $id, $matches)) {
                    $this->setupImplementationInService($id, $matches["moduleName"], $matches["entityName"], $container);
            } else {
                throw new LogicException("Tagged service: '$id' with '" . self::TAG . "' tag hasn't valid id format. Format must be App\\Module\\<moduleName>\\Domain\\Repository\\<entityNameRepository>");
            }

        }
    }

    private function setupImplementationInService(string $serviceId, string $moduleName, string $domainEntityName, ContainerBuilder $container)
    {
        file_put_contents("test", $serviceId);
        $def = $container->findDefinition($serviceId);
        $def->setFactory([new Reference('doctrine.orm.account_entity_manager'), 'getRepository']);
        $def->setArguments([$this->generateDoctrineEntityName($moduleName, $domainEntityName)]);
    }

    private function generateDoctrineEntityName(string $moduleName, string $domainEntityName)
    {
        return 'App\\Module\\' . $moduleName . '\\Infrastructure\\Persistence\Doctrine\Entity\\' . $domainEntityName . "Doctrine";
    }
}
