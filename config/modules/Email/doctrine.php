<?php

use App\Module\Email\Infrastructure\Persistence\Doctrine\EmailDoctrineType;

return [
    "isAccountModule" => true,
    "customTypes" => [
        EmailDoctrineType::NAME => EmailDoctrineType::class
    ],
];

