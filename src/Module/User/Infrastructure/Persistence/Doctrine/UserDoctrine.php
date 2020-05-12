<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Module\User\Domain\SharedKernel\UserId;
use App\Module\User\Domain\Entity\User;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="UserDoctrineRepository")
 * @Table(
 *     name="User_Users"
 * )
 **/
class UserDoctrine
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

    public static function fromDomain(User $domain): self
    {
        $doctrine = new self();
        $doctrine->id = $domain->getId()->getRaw();
        return $doctrine
            ->setName($domain->getName());
    }

    public function toDomain(): User
    {
        return new User(
            UserId::create($this->getId()),
            $this->getName());
    }
}
