<?php

use App\Module\TodoList\Domain\ValueObject\TaskStatus;
use App\Module\TodoList\Infrastructure\Persistence\Doctrine\TaskIdDoctrineType;

return [
    "isAccountModule" => true,
    "enumTypes" => [
        TaskStatus::class
    ],
    "customTypes" => [
        TaskIdDoctrineType::NAME => TaskIdDoctrineType::class
    ],
];

