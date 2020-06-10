<?php


namespace App\Module\TodoList\Application\Event\Task;


use App\Core\Message\Event\EventHandler;
use App\Module\TodoList\Domain\Event\TaskCreatedEvent;

class TaskCreatedEventHandler implements EventHandler
{
    public function __invoke(TaskCreatedEvent $event): void
    {

    }
}
