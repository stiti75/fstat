<?php
// src/AppBundle/Entity/User.php

namespace UtilisateursBundle\Entity;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Combine;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Utilisateurs extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**

   * @ORM\ManyToMany(targetEntity="FootstatBundle\Entity\Equipes", cascade={"persist"})

   */
    private $equipes;
    
    /**

   * @ORM\ManyToMany(targetEntity="FootstatBundle\Entity\Combine", cascade={"persist"})

   */
    private $combines;
   
    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->equipes = new ArrayCollection();
        $this->combines = new ArrayCollection();
    }
     public function addEquipe(Equipes $equipe)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->equipes[] = $equipe;

    return $this;
  }

  public function removeEquipe(Equipes $equipe)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->equipes->removeElement($equipe);
  }

  // Notez le pluriel, on récupère une liste de catégories ici !
  public function getEquipes()
  {
    return $this->equipes;
  }

   public function addCombine(Combine $combine)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->combines[] = $combine;

    return $this;
  }

  public function removeCombine(Combines $combine)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->combines->removeElement($combine);
  }

  // Notez le pluriel, on récupère une liste de catégories ici !
  public function getCombines()
  {
    return $this->combines;
  }

}

