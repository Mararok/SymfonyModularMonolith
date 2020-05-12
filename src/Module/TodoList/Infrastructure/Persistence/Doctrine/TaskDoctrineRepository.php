<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\DomainDoctrineRepositoryBase;
use App\Core\Domain\Exception\NotFoundException;
use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\Repository\TaskRepository;

class TaskDoctrineRepository extends DomainDoctrineRepositoryBase implements TaskRepository
{

    public function create(Task $task): void
    {
        $this->save($task);
    }

    protected function fromDomainEntity($domainEntity)
    {
        return TaskDoctrine::fromDomain($domainEntity);
    }

    protected function toDomainEntity($doctrineEntity)
    {
        /** @var TaskDoctrine $doctrineEntity */
        return $doctrineEntity->toDomain();
    }

    public function findById(int $id): Task
    {
        $entity = $this->tryFindById($id);
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $entity;
    }
}
