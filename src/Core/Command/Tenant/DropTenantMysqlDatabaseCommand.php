<?php


namespace App\Core\Command\Tenant;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropTenantMysqlDatabaseCommand extends TenantCommand
{

    protected function configure()
    {
        parent::configure();
        $this
            ->setName("app:tenant:doctrine:drop")
            ->setDescription("Drops tenant mysql database")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $command = $this->getApplication()->find("doctrine:database:drop");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:schema:create",
            "--connection"  => "tenant",
            "--force" => true,
        ]);
        $command->run($createDatabaseArguments, $output);

        return 0;
    }
}
