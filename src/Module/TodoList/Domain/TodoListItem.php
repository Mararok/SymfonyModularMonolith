<?php


namespace App\Module\TodoList\Domain;


use DateTimeInterface;

class TodoListItem implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $created;

    /**
     * @var TodoListItemStatus
     */
    private $status;

    /**
     * @var string
     */
    private $description;

    public function __construct(int $id, DateTimeInterface $created, TodoListItemStatus $status, string $description)
    {
        $this->id = $id;
        $this->created = $created;
        $this->status = $status;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreated(): DateTimeInterface
    {
        return $this->created;
    }

    public function getStatus(): TodoListItemStatus
    {
        return $this->status;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function jsonSerialize()
    {
        $data = get_object_vars($this);
        $data["created"] = $this->created->format(DATE_ATOM);
        return $data;
    }
}
