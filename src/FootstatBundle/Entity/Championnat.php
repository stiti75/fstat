<?php

namespace FootstatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Championnat
 *
 * @ORM\Table(name="championnat")
 * @ORM\Entity(repositoryClass="FootstatBundle\Repository\ChampionnatRepository")
 */
class Championnat {

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
     */
    private $nom;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    /**
     * @ORM\OneToOne(targetEntity="FootstatBundle\Entity\Media", cascade={"persist"})
     */
    private $media;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Championnat
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }
    
    /**
     * Set url
     *
     * @param string $url
     * @return Championnat
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
    }
    
    public function setMedia(Media $media = null) {
        $this->media = $media;
    }

    public function getMedia() {
        return $this->media;
    }

}
