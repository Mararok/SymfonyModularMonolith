<?php


namespace App\Module\User\Domain\Repository;



use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\SharedKernel\UserId;

interface UserRepository
{
    public function create(User $user): void;

    /**
     * @return \Iterator
     */
    public function findAll();
    public function findById(UserId $userId): User;
}
