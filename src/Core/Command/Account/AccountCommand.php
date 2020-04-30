<?php


namespace App\Core\Command\Account;


use App\Core\Account\Doctrine\DoctrineAccountContextService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AccountCommand extends Command
{
    public const COMMAND_NAME_PREFIX = "app:account:";
    public const OPT_ACCOUNT_ID = "account-id";

    /**
     * @var DoctrineAccountContextService
     */
    private DoctrineAccountContextService $service;

    public function __construct(DoctrineAccountContextService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    protected function configure()
    {
        $this
            ->addOption(self::OPT_ACCOUNT_ID, "aid", InputOption::VALUE_REQUIRED, "Choose account context ");
    }

    public function setName(string $name)
    {
        return parent::setName(self::COMMAND_NAME_PREFIX.$name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accountId = (int)$input->getOption(self::OPT_ACCOUNT_ID);

        if ($accountId <= 0) {
            $output->writeln("<error>account-id must be numeric and greater then 0</error>");
            return 255;
        }

        $this->service->switchAccount($accountId);
        $output->writeln("<info>Connection switched to selected account database</info>");

        return $this->executeCommand($input, $output);
    }

    protected abstract function executeCommand(InputInterface $input, OutputInterface $output);
}
