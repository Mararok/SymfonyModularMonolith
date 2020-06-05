<?php


namespace App\Module\TodoList\Domain\Entity;


use App\Module\TodoList\Domain\ValueObject\TaskStatus;
use App\Module\User\Domain\SharedKernel\UserId;
use DateTimeInterface;

class Task implements \JsonSerializable
{
    private int $id;
    private string $name;
    private DateTimeInterface $createdAt;
    private TaskStatus $status;
    private UserId $assignedUserId;

    public function __construct(int $id, DateTimeInterface $createdAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): void
    {
        $this->status = $status;
    }

    public function getAssignedUserId(): UserId
    {
        return $this->assignedUserId;
    }

    public function setAssignedUserId(UserId $assignedUserId): void
    {
        $this->assignedUserId = $assignedUserId;
    }

    public function jsonSerialize()
    {
        $data = get_object_vars($this);
        $data["createdAt"] = $this->createdAt->format(DATE_ATOM);
        return $data;
    }
}
