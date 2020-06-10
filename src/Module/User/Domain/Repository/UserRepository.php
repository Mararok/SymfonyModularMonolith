<?php


namespace App\Module\User\Domain\Repository;


use App\Module\User\Domain\Entity\User;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

interface UserRepository
{
    public function saveOrUpdate(User $user): void;

    public function getList(): \Iterator;

    public function getById(UserId $userId): User;

    public function exists(UserId $userId): bool;

    public function delete(User $user): void;
}
