<?php


namespace App\Module\TodoList\Application\Query\Task\FindById;


use App\Core\Message\Query\Query;
use Assert\Assertion;
use Assert\AssertionFailedException;

class FindByIdQuery implements Query
{
    private int $id;

    /**
     *
     * @param int $id
     * @throws AssertionFailedException
     */
    public function __construct(int $id)
    {
        Assertion::greaterThan($id, 0, "Id must be greater then 0");
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }


}
