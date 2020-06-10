<?php


namespace App\Module\TodoList\Domain\Entity;


use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\TodoList\Domain\ValueObject\TaskStatus;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
use DateTimeInterface;

class Task implements \JsonSerializable
{
    private TaskId $id;
    private string $name;
    private DateTimeInterface $createdAt;
    private TaskStatus $status;
    private UserId $assignedUserId;

    public function __construct(TaskId $id, string $name, DateTimeInterface $createdAt, TaskStatus $status, UserId $assignedUserId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->status = $status;
        $this->assignedUserId = $assignedUserId;
    }

    public static function createNew(string $name)
    {
        return new self(
            TaskId::emptyValue(),
            $name,
            \DateTimeImmutable::createFromFormat("U", time()),
            TaskStatus::TODO(),
            UserId::emptyValue()
        );
    }

    public function getId(): TaskId
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
