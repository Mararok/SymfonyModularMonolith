<?php


namespace App\Module\TodoList\Domain;


use DateTimeInterface;

class Task implements \JsonSerializable
{
    private int $id;
    private string $name;
    private DateTimeInterface $createdAt;
    private TaskStatus $status;

    public function __construct(int $id, string $name, DateTimeInterface $createdAt, TaskStatus $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function jsonSerialize()
    {
        $data = get_object_vars($this);
        $data["createdAt"] = $this->createdAt->format(DATE_ATOM);
        return $data;
    }
}
