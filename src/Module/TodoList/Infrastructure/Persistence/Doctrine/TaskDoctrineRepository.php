<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\DomainDoctrineRepositoryBase;
use App\Core\Domain\Exception\NotFoundException;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Repository\TaskRepository;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;

class TaskDoctrineRepository extends DomainDoctrineRepositoryBase implements TaskRepository
{

    public function saveOrUpdate(Task $task): void
    {
        $this->save($task);
    }

    public function getById(TaskId $id): Task
    {
        $entity = $this->tryGetById($id);
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $entity;
    }

    public function delete(Task $task): void
    {
        $this->deleteEntity($task);
    }
}
