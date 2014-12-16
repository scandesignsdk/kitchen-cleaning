<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Point
 *
 * @ORM\Table(name="point")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\PointRepository")
 */
class Point
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", name="user_id")
     */
    private $user;

    /**
     * @var Cleaning
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cleaning", inversedBy="points")
     */
    private $cleaning;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $point;


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
     * Set point
     *
     * @param integer $point
     * @return Point
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return integer 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Point
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set cleaning
     *
     * @param Cleaning $cleaning
     * @return Point
     */
    public function setCleaning(Cleaning $cleaning = null)
    {
        $this->cleaning = $cleaning;

        return $this;
    }

    /**
     * Get cleaning
     *
     * @return Cleaning
     */
    public function getCleaning()
    {
        return $this->cleaning;
    }
}
