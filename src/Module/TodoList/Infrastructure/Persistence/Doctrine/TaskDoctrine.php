<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine;


use App\Module\TodoList\Domain\Entity\Task;
use App\Module\TodoList\Domain\SharedKernel\ValueObject\TaskId;
use App\Module\TodoList\Domain\ValueObject\TaskStatus;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="TaskDoctrineRepository")
 * @Table(
 *     name="TodoList_Tasks"
 * )
 **/
class TaskDoctrine
{
    /**
     * @Id
     * @Column(type="TodoList.TaskId", options={"unsigned": true})
     * @GeneratedValue
     */
    private TaskId $id;

    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @Column(type="datetime_immutable")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @Column(type="App\Module\TodoList\Domain\ValueObject\TaskStatus")
     */
    private TaskStatus $status;

    /**
     * @Column(type="User.UserId")
     */
    private UserId $assignedUserId;

    public function getId(): TaskId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return $this->status;
    }

    public function setStatus(TaskStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getAssignedUserId(): UserId
    {
        return $this->assignedUserId;
    }

    public function setAssignedUserId(UserId $assignedUserId): TaskDoctrine
    {
        $this->assignedUserId = $assignedUserId;
        return $this;
    }

    public function populateFromDomain(Task $domain): self
    {
        $this->name = $domain->getName();
        $this->status = $domain->getStatus();
        $this->assignedUserId = $domain->getAssignedUserId();
        return $this;
    }

    public static function fromDomain(Task $domain): self
    {
        $doctrine = new self();
        $doctrine->id = $domain->getId();
        return $doctrine
            ->setName($domain->getName())
            ->setCreatedAt($domain->getCreatedAt())
            ->setStatus($domain->getStatus())
            ->setAssignedUserId($domain->getAssignedUserId());
    }

    public function toDomain(): Task
    {
        return new Task(
            $this->getId(),
            $this->getName(),
            $this->getCreatedAt(),
            $this->getStatus(), $this->getAssignedUserId());
    }
}
