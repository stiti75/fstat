<?php

namespace FootstatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matches
 *
 * @ORM\Table(name="matches")
 * @ORM\Entity(repositoryClass="FootstatBundle\Repository\MatchesRepository")
 */
class Matches
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
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Equipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipeDom;

    /**
     * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Equipes")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $equipeExt;

    /**
     * @var date
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="score1", type="integer", length=255)
     */
    private $score1;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="score2", type="integer", length=255)
     */
    private $score2;
    
    
    
    /**
    * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Championnat")
    * @ORM\JoinColumn(nullable=false)
    */
    private $championnat;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    public function setEquipeDom(Equipes $equipeDom)
  {
    $this->equipeDom = $equipeDom;

    return $this;
  }

  public function getEquipeDom()
  {
    return $this->equipeDom;
  }

   public function setEquipeExt(Equipes $equipeExt)
  {
    $this->equipeExt = $equipeExt;

    return $this;
  }

  public function getEquipeExt()
  {
    return $this->equipeExt;
  }
    
    /**
     * Set date
     *
     * @param date $date
     * @return Matches
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set score1
     *
     * @param integer $score1
     * @return Matches
     */
    public function setScore1($score1)
    {
        $this->score1 = $score1;

        return $this;
    }

    /**
     * Get score1
     *
     * @return integer 
     */
    public function getScore1()
    {
        return $this->score1;
    }
    
     /**
     * Set score2
     *
     * @param integer $score2
     * @return Matches
     */
    public function setScore2($score2)
    {
        $this->score2 = $score2;

        return $this;
    }

    /**
     * Get score2
     *
     * @return integer 
     */
    public function getScore2()
    {
        return $this->score2;
    }
    
     public function setChampionnat(Championnat $championnat)
  {
    $this->championnat = $championnat;

    return $this;
  }

  public function getChampionnat()
  {
    return $this->championnat;
  }
  
      /**
     * Set type
     *
     * @param integer $type
     * @return Matches
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
  
}
