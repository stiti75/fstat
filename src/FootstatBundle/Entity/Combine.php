<?php

namespace FootstatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Combine
 *
 * @ORM\Table(name="combine")
 * @ORM\Entity(repositoryClass="FootstatBundle\Repository\CombineRepository")
 */
class Combine
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
     /**
     * @var int
     *
     * @ORM\Column(name="saved", type="integer")
     */
    private $saved;

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
     * @return Combine
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
     * Set saved
     *
     * @param integer $saved
     * @return Equipes
     */
    public function setSaved($saved)
    {
        $this->saved = $saved;

        return $this;
    }

    /**
     * Get saved
     *
     * @return integer 
     */
    public function getSaved()
    {
        return $this->saved;
    }
}
