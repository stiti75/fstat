<?php

namespace FootstatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parie
 *
 * @ORM\Table(name="parie")
 * @ORM\Entity(repositoryClass="FootstatBundle\Repository\ParieRepository")
 */
class Parie
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
     * @var string
     *
     * @ORM\Column(name="cote", type="string", length=255)
     * 
     */
    private $cote;
    
    /**
    * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Combine")
    * @ORM\JoinColumn(name="Combine_id", referencedColumnName="id", onDelete="CASCADE")
    */
    private $combine;
    
    /**
    * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Matches")
    */
    private $match;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    public function setCombine(Combine $combine)
  {
    $this->combine = $combine;

    return $this;
  }

  public function getCombine()
  {
    return $this->combine;
  }
  
  
  public function setMatch(Matches $match)
  {
    $this->match = $match;

    return $this;
  }

  public function getMatch()
  {
    return $this->match;
  }
  
  /**
     * Set cote
     *
     * @param string $cote
     * @return Parie
     */
    public function setCote($cote)
    {
        $this->cote = $cote;

        return $this;
    }

    /**
     * Get cote
     *
     * @return string 
     */
    public function getCote()
    {
        return $this->cote;
    }
}
