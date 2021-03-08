<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlaceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Place
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Exclude()
     */
    public $id;

    /**
     * @ORM\Column(name="random_id", type="integer")
     * @JMS\SerializedName("id")
     */
    public $random_id;

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

    /**
     * @ORM\PrePersist
     */
    public function onPreEvents()
    {
        $this->random_id = random_int(PHP_INT_MIN,PHP_INT_MAX);
    }

}
