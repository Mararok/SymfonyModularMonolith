<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Core\Doctrine\DomainDoctrineRepositoryBase;
use App\Core\Domain\Exception\NotFoundException;
use App\Module\User\Domain\SharedKernel\UserId;
use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\Repository\UserRepository;

class UserDoctrineRepository extends DomainDoctrineRepositoryBase implements UserRepository
{

    public function create(User $user): void
    {
        $this->save($user);
    }

    protected function fromDomainEntity($domainEntity)
    {
        return UserDoctrine::fromDomain($domainEntity);
    }

    protected function toDomainEntity($doctrineEntity)
    {
        /** @var UserDoctrine $doctrineEntity */
        return $doctrineEntity->toDomain();
    }

    public function findById(UserId $id): User
    {
        $entity = $this->tryFindById($id);
        if (!$entity) {
            throw NotFoundException::create();
        }

        return $entity;
    }

    protected function toIdValue($id)
    {
        return parent::toIdValue($id);
    }
}
