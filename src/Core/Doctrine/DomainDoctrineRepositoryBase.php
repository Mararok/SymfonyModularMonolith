<?php


namespace App\Core\Doctrine;

use Doctrine\ORM\EntityRepository;

abstract class DomainDoctrineRepositoryBase extends EntityRepository
{
    /**
     * Persists entity in database
     * @param mixed $domainEntity
     */
    protected function save(object $domainEntity): void
    {
        try {
            $doctrineEntity = $this->fromDomainEntity($domainEntity);
            $this->getEntityManager()->persist($doctrineEntity);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }

    public function getList(): \Iterator
    {
        try {
            $doctrineEntities = parent::findAll();
            $domainEntities = [];
            foreach ($doctrineEntities as $doctrineEntity) {
                $domainEntities[] = $doctrineEntity->toDomain();
            }
            return new \ArrayIterator($domainEntities);
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
            $doctrineEntity = $this->find($id);
            return $doctrineEntity ? $this->toDomainEntity($doctrineEntity) : null;
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
        }
    }

    protected function deleteEntity($entity)
    {
        try {
            $doctrineEntity = $this->fromDomainEntity($entity);
            $this->getEntityManager()->remove($doctrineEntity);
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            throw DoctrinePersistenceException::createFromDoctrine($e);
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
}
