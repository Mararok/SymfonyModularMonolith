<?php

use App\Module\TodoList\Domain\ValueObject\TaskStatus;

return [
    "isAccountModule" => true,
    "enumTypes" => [
        TaskStatus::class
    ]
];

