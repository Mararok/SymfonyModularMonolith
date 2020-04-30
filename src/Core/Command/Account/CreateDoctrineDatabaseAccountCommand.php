<?php


namespace App\Core\Command\Account;


use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDoctrineDatabaseAccountCommand extends AccountCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName("doctrine:create")
            ->setDescription("Creates account mysql database");
    }

    protected function executeCommand(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find("doctrine:database:create");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:database:create",
            "--connection" => "account",
        ]);
        if ($command->run($createDatabaseArguments, $output) !== 0) {
            return 255;
        }

        $command = $this->getApplication()->find("doctrine:schema:create");
        $createDatabaseArguments = new ArrayInput([
            "command" => "doctrine:schema:create",
            "--em" => "account",
        ]);
        if ($command->run($createDatabaseArguments, $output) !== 0) {
            return 255;
        }

        return 0;
    }
}
