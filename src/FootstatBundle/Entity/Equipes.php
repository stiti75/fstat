<?php

namespace FootstatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipes
 *
 * @ORM\Table(name="equipes")
 * @ORM\Entity(repositoryClass="FootstatBundle\Repository\EquipesRepository")
 */
class Equipes
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
     * @ORM\Column(name="Nom", type="string", length=255)
     * 
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255)
     */
    private $lien;

    /**
     * @var int
     *
     * @ORM\Column(name="Classement", type="integer")
     */
    private $classement;
    /**
     * @var int
     *
     * @ORM\Column(name="jeu", type="integer")
     */
    private $jeu;
    /**
     * @var int
     *
     * @ORM\Column(name="pts", type="integer")
     */
    private $pts;
    
    /**
     * @var string
     *
     * @ORM\Column(name="diff", type="string", length=255)
     */
    private $diff;
     
    /**
     * @ORM\OneToOne(targetEntity="FootstatBundle\Entity\Media", cascade={"persist"})
     */
    private $media;
    
    /**
    * @ORM\ManyToOne(targetEntity="FootstatBundle\Entity\Championnat")
    * @ORM\JoinColumn(name="Championnat_id", referencedColumnName="id", onDelete="CASCADE")
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

    /**
     * Set nom
     *
     * @param string $nom
     * @return Equipes
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return Equipes
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
     * Set classement
     *
     * @param integer $classement
     * @return Equipes
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;

        return $this;
    }

    /**
     * Get classement
     *
     * @return integer 
     */
    public function getClassement()
    {
        return $this->classement;
    }
    
    /**
     * Set pts
     *
     * @param integer $pts
     * @return Equipes
     */
    public function setPts($pts)
    {
        $this->pts = $pts;

        return $this;
    }

    /**
     * Get pts
     *
     * @return integer 
     */
    public function getPts()
    {
        return $this->pts;
    }
    
    /**
     * Set jeu
     *
     * @param integer $jeu
     * @return Equipes
     */
    public function setJeu($jeu)
    {
        $this->jeu = $jeu;

        return $this;
    }

    /**
     * Get jeu
     *
     * @return integer 
     */
    public function getJeu()
    {
        return $this->jeu;
    }
    
    /**
     * Set diff
     *
     * @param string $diff
     * @return Equipes
     */
    public function setDiff($diff)
    {
        $this->diff = $diff;

        return $this;
    }

    /**
     * Get diff
     *
     * @return string 
     */
    public function getDiff()
    {
        return $this->diff;
    }
    
    
    public function setMedia(Media $media = null) {
        $this->media = $media;
    }

    public function getMedia() {
        return $this->media;
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
  
 

  

}
