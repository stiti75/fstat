<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace FootstatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FootstatBundle\Entity\Championnat;


class LoadChampionnatData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
            
    {   
        $lpChampionnat = new Championnat();
        $lpChampionnat->setNom('Premier League');
        $lpChampionnat->setUrl('http://www.lequipe.fr/Football/championnat-d-angleterre-classement.html');
        $lpChampionnat->setMedia($this->getReference('lp-media'));
        
        $lgChampionnat = new Championnat();
        $lgChampionnat->setNom('Lliga');
        $lgChampionnat->setUrl('http://www.lequipe.fr/Football/championnat-d-espagne-classement.html');
        $lgChampionnat->setMedia($this->getReference('lg-media'));
        
        $blChampionnat = new Championnat();
        $blChampionnat->setNom('Bundisliga');
        $blChampionnat->setUrl('http://www.lequipe.fr/Football/championnat-d-allemagne-classement.html');
        $blChampionnat->setMedia($this->getReference('bl-media'));
        
        $manager->persist($lpChampionnat);
        $manager->persist($lgChampionnat);
        $manager->persist($blChampionnat);
        $manager->flush();
    }
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}

