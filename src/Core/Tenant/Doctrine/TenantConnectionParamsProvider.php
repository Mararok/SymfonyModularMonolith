<?php


namespace App\Core\Tenant\Doctrine;


use App\Core\Doctrine\ConnectionParamsProvider;

class TenantConnectionParamsProvider implements ConnectionParamsProvider
{
    private array $baseParams;

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


    public function get(string $connectionId): array
    {
        $params = $this->baseParams;
        $params["dbname"] = $this->getDatabaseName($connectionId);
        return $params;
    }

    private function getDatabaseName(string $connectionId) {
        return ($connectionId === "system") ? "system" : "tenant_$connectionId";
    }
}
