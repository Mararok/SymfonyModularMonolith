<?php


namespace App\Core\Account\Doctrine;


class AccountConnectionParamsProvider
{
    private array $baseParams;
    private string $dbnamePrefix = "account_";

    public function __construct()
    {
        // @TODO change to env config
        $this->baseParams = [
            "host" => "localhost",
            "port" => "10003",
            "user" => "root",
            "password" => "test",
            'driver' => 'pdo_mysql',
            'server_version' => '5.7',
            'charset' => 'utf8mb4',
        ];
    }


    public function get(string $accountId): array
    {
        $params = $this->baseParams;
        $params["dbname"] = $this->getDatabaseName($accountId);
        return $params;
    }

    private function getDatabaseName(string $accountId) {
        return $this->dbnamePrefix.$accountId;
    }
}
