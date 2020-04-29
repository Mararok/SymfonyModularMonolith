<?php


namespace App\Core\Doctrine;


interface ConnectionParamsProvider
{
    public function get(string $connectionId): array;
}
