<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
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
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    public $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    public $lastname;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;

    /**
     * @ORM\Column(name="phone", type="string", length=10)
     */
    public $phone;

    /**
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="contacts")
     * @JMS\Exclude()
     */
    public $place;

    /**
     * @ORM\PrePersist
     */
    public function onPreEvents()
    {
        $this->random_id = random_int(1,PHP_INT_MAX);
    }
}
