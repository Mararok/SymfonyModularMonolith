<?php

use App\Module\TodoList\Domain\TaskStatus;

return [
    "isAccountModule" => true,
    "enumTypes" => [
        TaskStatus::class
    ]
];

