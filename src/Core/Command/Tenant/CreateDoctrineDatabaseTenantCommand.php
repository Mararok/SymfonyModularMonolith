<?php


namespace App\Core\Command\Tenant;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDoctrineDatabaseTenantCommand extends TenantCommand
{

    protected function configure()
    {
        parent::configure();
        $this
            ->setName("app:tenant:doctrine:create")
            ->setDescription("Creates tenant mysql database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $command = $this->getApplication()->find("doctrine:database:create");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:database:create",
            "--connection" => "tenant",
        ]);
        if ($command->run($createDatabaseArguments, $output) !== 0) {
            return 255;
        }

        $command = $this->getApplication()->find("doctrine:schema:create");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:schema:create",
            "--em" => "tenant",
        ]);
        if ($command->run($createDatabaseArguments, $output) !== 0) {
            return 255;
        }

        return 0;
    }
}
