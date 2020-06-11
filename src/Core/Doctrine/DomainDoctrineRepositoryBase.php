<?php


namespace App\Core\Doctrine;

use Doctrine\ORM\EntityRepository;

abstract class DomainDoctrineRepositoryBase extends EntityRepository
{
    protected function save(object $entity): void
    {
        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }

    public function getList(): \Iterator
    {
        try {
            $entities = parent::findAll();
            return new \ArrayIterator($entities);
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }

    /**
     *
     * @param $id mixed Id of entity
     * @return mixed | null
     */
    protected function tryGetById($id)
    {
        try {
            return $doctrineEntity = $this->find($id);
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }

    protected function deleteEntity($entity)
    {
        try {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }
}
