<?php


namespace App\Core\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateTenantMysqlDatabaseCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:tenant:create-mysql-database';

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        return 0;
    }
}
