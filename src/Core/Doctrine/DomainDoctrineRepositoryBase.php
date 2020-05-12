<?php


namespace App\Core\Doctrine;

use Doctrine\ORM\EntityRepository;

abstract class DomainDoctrineRepositoryBase extends EntityRepository
{
    /**
     * Persists entity in database
     * @param mixed $domainEntity
     */
    protected function save($domainEntity): void
    {
        try {
            $this->getEntityManager()->persist($this->fromDomainEntity($domainEntity));
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::create("Doctrine error", $e);
        }
    }

    public function findAll()
    {
        try {
            $doctrineEntities = parent::findAll();
            $domainEntities = [];
            foreach ($doctrineEntities as $doctrineEntity) {
                $domainEntities[] = $doctrineEntity->toDomain();
            }
            return new \ArrayIterator($domainEntities);
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::create("Doctrine error", $e);
        }
    }

    /**
     *
     * @param $id mixed Id of
     * @return mixed | null
     */
    protected function tryFindById($id)
    {
        try {
            $doctrineEntity = $this->find($this->toIdValue($id));
            return $doctrineEntity ? $this->toDomainEntity($doctrineEntity) : null;
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::create("Doctrine error", $e);
        }
    }

    /**
     * Converts domain entity object to doctrine entity object
     * @param $domainEntity
     * @return mixed DoctrineEntity
     */
    protected abstract function fromDomainEntity($domainEntity);

    /**
     * Converts doctrine entity to domain entity object
     * @param $doctrineEntity
     * @return mixed Domain entity
     */
    protected abstract function toDomainEntity($doctrineEntity);

    /**
     * Converts given id to value(some ids can be complex objects)
     * @param mixed $id
     * @return mixed
     */
    protected function toIdValue($id)
    {
        return $id;
    }
}
