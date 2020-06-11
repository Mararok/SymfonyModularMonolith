<?php


use App\Module\User\Infrastructure\Persistence\Doctrine\UserIdDoctrineType;

return [
    "isAccountModule" => true,
    "customTypes" => [
        UserIdDoctrineType::class
    ],
];

