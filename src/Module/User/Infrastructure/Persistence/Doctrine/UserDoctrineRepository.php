<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\DomainDoctrineRepositoryBase;
use App\Core\Domain\Exception\NotFoundException;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class UserDoctrineRepository extends DomainDoctrineRepositoryBase implements UserRepository
{

    public function saveOrUpdate(User $user): void
    {
        $this->save($user);
    }

    public function getById(UserId $id): User
    {
        $entity = $this->tryGetById($id);
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $entity;
    }

    public function exists(UserId $id): bool
    {
        return (bool)$this->tryGetById($id);
    }

    public function delete(User $user): void
    {
        $this->deleteEntity($user);
    }

    protected function toDomainEntity($doctrineEntity)
    {
        /** @var UserDoctrine $doctrineEntity */
        return $doctrineEntity->toDomain();
    }

    protected function fromDomainEntity($domainEntity)
    {
        return UserDoctrine::fromDomain($domainEntity);
    }
}
