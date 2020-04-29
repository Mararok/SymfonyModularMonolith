<?php


namespace App\Core\Command\Tenant;


use App\Core\Tenant\Doctrine\TenantConnectionContextService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class TenantCommand extends Command
{
    public const ARG_TENANT_ID = "tenant-id";

    private TenantConnectionContextService $connectionContextService;

    public function __construct(TenantConnectionContextService $connectionContextService)
    {
        parent::__construct();
        $this->connectionContextService = $connectionContextService;
    }

    protected function configure()
    {
        $this
            ->addArgument(self::ARG_TENANT_ID, InputArgument::REQUIRED, "Choose tenant context ");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tenantId = $input->getArgument(self::ARG_TENANT_ID);
        $this->connectionContextService->switchConnection($tenantId);
        $output->writeln("Connection switched selected tenant database");

    }
}
