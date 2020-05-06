<?php


namespace App\Module\TodoList\Domain\ValueObject;


use MyCLabs\Enum\Enum;

class TaskStatus extends Enum
{
    private const TODO = "todo";
    private const IN_PROGRESS = "in_progress";
    private const DONE = "done";

    public static function TODO(): self
    {
        return new self(self::TODO);
    }

    public static function IN_PROGRESS(): self
    {
        return new self(self::IN_PROGRESS);
    }

    public static function DONE(): self
    {
        return new self(self::DONE);
    }
}
