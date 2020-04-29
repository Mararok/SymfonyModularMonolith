<?php


namespace App\Module\TodoList\Infrastructure\Persistence\Doctrine\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(
 *     name="Tasks"
 * )
 **/
class TaskDoctrine
{
    /**
     * @Id
     * @Column(type="integer", options={"unsigned": true})
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="integer", options={"unsigned": true})
     * @var int
     */
    private $createdAt;

    /**
     * @Column(type="integer", options={"unsigned": true})
     * @var int
     */
    private $expires;

    /**
     * @Column(type="integer", options={"unsigned": true})
     * @var int
     */
    private $currentCount;

}
