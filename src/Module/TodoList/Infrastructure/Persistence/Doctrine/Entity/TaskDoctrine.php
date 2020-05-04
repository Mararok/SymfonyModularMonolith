<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine\Entity;


use App\Module\TodoList\Domain\Task;
use App\Module\TodoList\Domain\TaskStatus;
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
     * @Column(type="integer", options={"unsigned": true})
     * @GeneratedValue
     */
    private int $id;

    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @Column(type="datetime_immutable")
     */
    private \DateTimeInterface $createdAt;

    /**
     * @Column(type="App\Module\TodoList\Domain\TaskStatus")
     */
    private TaskStatus $status;

    public function getId(): int
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

    public static function fromDomain(Task $domain): self
    {
        $doctrine = new self();
        $doctrine->id = $domain->getId();
        return $doctrine
            ->setName($domain->getName())
            ->setCreatedAt($domain->getCreatedAt())
            ->setStatus($domain->getStatus());
    }

    public function toDomain(): Task
    {
        return new Task(
            $this->getId(),
            $this->getName(),
            $this->getCreatedAt(),
            $this->getStatus());
    }
}
