<?php

use App\Module\TodoList\Domain\TaskStatus;

return [
    "isTenantModule" => true,
    "enumTypes" => [
        "todolist_enum_status" => TaskStatus::class
    ]
];
