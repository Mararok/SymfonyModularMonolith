<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine\Entity;


use App\Module\TodoList\Domain\Task;
use App\Module\TodoList\Domain\TaskRepository;
use Doctrine\ORM\EntityRepository;

class TaskDoctrineRepository extends EntityRepository implements TaskRepository
{

    public function create(Task $task): void
    {
        $doctrineEntity = TaskDoctrine::fromDomain($task);
        $this->getEntityManager()->persist($doctrineEntity);
        $this->getEntityManager()->flush($doctrineEntity);
    }

    public function findAll(): \Iterator
    {
        $doctrineEntities = parent::findAll();
        $domainEntities = [];
        foreach ($doctrineEntities as $doctrineEntity) {
            $domainEntities[] = $doctrineEntity->toDomain();
        }
        return new \ArrayIterator($domainEntities);
    }

    public function findById(int $id): ?Task
    {
        /** @var TaskDoctrine $doctrineEntity */
        $doctrineEntity = $this->find($id);
        if ($doctrineEntity) {
            return $doctrineEntity->toDomain();
        }

        return null;
    }
}
