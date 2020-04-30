<?php


namespace App\Core\Command\Account;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropDoctrineDatabaseAccountCommand extends AccountCommand
{

    protected function configure()
    {
        parent::configure();
        $this
            ->setName("doctrine:drop")
            ->setDescription("Drops account mysql database")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $command = $this->getApplication()->find("doctrine:database:drop");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:schema:create",
            "--connection"  => "account",
            "--force" => true,
        ]);
        $command->run($createDatabaseArguments, $output);

        return 0;
    }
}
