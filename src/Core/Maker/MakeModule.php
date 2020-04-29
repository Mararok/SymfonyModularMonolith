<?php


namespace App\Core\Maker;


use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class MakeModule extends AbstractMaker
{
    private const BASE_MODULE_PATH = "src/Module";
    private const MODULE_DIRS = [
      "Application",
      "Domain",
      "Infrastructure"
    ];

    public static function getCommandName(): string
    {
        return "make:module";
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription("Creates a new module in project")
            ->addArgument("module-name", InputArgument::REQUIRED, "Choose a name for your module ",)
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $moduleName =  $input->getArgument("module-name");

        $moduleRootDir = $generator->getRootDirectory()."/".self::BASE_MODULE_PATH."/".$moduleName;

        if (file_exists($moduleRootDir)) {
            $io->error("Module with selected name exists");
            return;
        }
        foreach (self::MODULE_DIRS as $moduleLayerDir) {
            mkdir($moduleRootDir."/".$moduleLayerDir, 0777, true);
        }

        $this->writeSuccessMessage($io);
        $io->text("Next: Add some code to module");
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }
}
