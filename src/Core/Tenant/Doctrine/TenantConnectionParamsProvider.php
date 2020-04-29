<?php


namespace App\Core\Tenant\Doctrine;


class TenantConnectionParamsProvider
{
    private array $baseParams;

    private string $dbnamePrefix = "tenant_";

    public function __construct()
    {
        // @TODO change to env config
        $this->baseParams = [
            "host" => "localhost",
            "port" => "10003",
            "user" => "root",
            "password" => "test",
        ];
    }


    public function get(string $tenantId): array
    {
        $params = $this->baseParams;
        $params["dbname"] = $this->getDatabaseName($tenantId);
        return $params;
    }

    private function getDatabaseName(string $tenantId) {
        return $this->dbnamePrefix.$tenantId;
    }
}
