<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cleaning
 *
 * @ORM\Table(name="cleaning")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CleaningRepository")
 */
class Cleaning
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", name="user_id")
     */
    private $user;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", name="backup_user_id")
     */
    private $backup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="use_backup", type="boolean")
     */
    private $useBackup = false;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Point", mappedBy="cleaning")
     */
    private $points;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->points = new ArrayCollection();
        $this->useBackup = false;
    }

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
     * Set date
     *
     * @param \DateTime $date
     * @return Cleaning
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set useBackup
     *
     * @param boolean $useBackup
     * @return Cleaning
     */
    public function setUseBackup($useBackup)
    {
        $this->useBackup = $useBackup;

        return $this;
    }

    /**
     * Get useBackup
     *
     * @return boolean 
     */
    public function getUseBackup()
    {
        return $this->useBackup;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Cleaning
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
     * Set backup
     *
     * @param User $backup
     * @return Cleaning
     */
    public function setBackup(User $backup = null)
    {
        $this->backup = $backup;

        return $this;
    }

    /**
     * Get backup
     *
     * @return User
     */
    public function getBackup()
    {
        return $this->backup;
    }

    /**
     * @return User
     */
    public function getUsedUser()
    {
        return ($this->getUseBackup() ? $this->getBackup() : $this->getUser());
    }

    /**
     * Add points
     *
     * @param Point $points
     * @return Cleaning
     */
    public function addPoint(Point $points)
    {
        $this->points[] = $points;

        return $this;
    }

    /**
     * Remove points
     *
     * @param Point $points
     */
    public function removePoint(Point $points)
    {
        $this->points->removeElement($points);
    }

    /**
     * Get points
     *
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
    }
}
