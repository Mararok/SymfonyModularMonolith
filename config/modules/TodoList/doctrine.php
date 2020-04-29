<?php

use App\Module\TodoList\Domain\TaskStatus;

return [
    "isTenantModule" => true,
    "enumTypes" => [
        TaskStatus::class
    ]
];

