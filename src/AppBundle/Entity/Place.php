<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 */
class Place
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    public $name;

    /**
     * @ORM\Column(name="address", type="string", length=255)
     */
    public $address;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    public $createdAt;

    /**
     * @ORM\Column(name="comment", type="string", length=255,nullable=true)
     */
    public $comment;

    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime;
    }

}
