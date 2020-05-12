<?php


namespace App\Module\User\Application\Query\User\FindById;


use App\Core\Message\Query\Query;
use App\Module\User\Domain\SharedKernel\UserId;
use Assert\Assertion;
use Assert\AssertionFailedException;

class FindByIdQuery implements Query
{
    private UserId $id;

    /**
     *
     * @param int $id
     * @throws AssertionFailedException
     */
    public function __construct(UserId $id)
    {
        Assertion::same($id, UserId::emptyValue(), "User id can't be empty");
        $this->id = $id;
    }

    public function getId(): UserId
    {
        return $this->id;
    }


}
