<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $cleaningnumbers = 0;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set cleaningnumbers
     *
     * @param integer $cleaningnumbers
     * @return User
     */
    public function setCleaningnumbers($cleaningnumbers)
    {
        $this->cleaningnumbers = $cleaningnumbers;

        return $this;
    }

    /**
     * Get cleaningnumbers
     *
     * @return integer 
     */
    public function getCleaningnumbers()
    {
        return $this->cleaningnumbers;
    }

    /**
     * @return $this
     */
    public function addCleaning()
    {
        $this->cleaningnumbers++;
        return $this;
    }

    /**
     * @return $this
     */
    public function removeCleaning()
    {
        $this->cleaningnumbers--;
        return $this;
    }
}
