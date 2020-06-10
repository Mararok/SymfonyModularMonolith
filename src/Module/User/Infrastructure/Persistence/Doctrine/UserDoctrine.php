<?php


namespace App\Module\User\Infrastructure\Persistence\Doctrine;


use App\Module\Email\Domain\SharedKernel\ValueObject\Email;
use App\Module\User\Domain\SharedKernel\ValueObject\UserId;
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
     * @Column(type="User.UserId")
     * @GeneratedValue(strategy="AUTO")
     */
    private UserId $id;

    /**
     * @Column(type="string")
     */
    private string $name;

    /**
     * @Column(type="Email.Email")
     */
    private Email $email;

    public function getId(): UserId
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

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function populateFromDomain(User $domain): self
    {
        $this->name = $domain->getName();
        $this->email = $domain->getEmail();
        return $this;
    }

    public static function fromDomain(User $domain): self
    {
        $doctrine = new self();
        $doctrine->id = $domain->getId();
        return $doctrine
            ->setName($domain->getName())
            ->setEmail($domain->getEmail());
    }

    public function toDomain(): User
    {
        return new User(
            $this->getId(),
            $this->getName(),
            $this->getEmail()
        );
    }
}
