<?php


namespace App\Module\User\Application\Query\User;


use App\Core\Message\Query\Query;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;

class ExistsQuery extends Query
{
    private UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}
