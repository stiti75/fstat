<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FootstatBundle\Entity\Media;

class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $plMedia = new Media();
        $plMedia->setAlt('Premier League');
        $plMedia->setUrl('https://prod-slcontent.s3.amazonaws.com/photos-cache/taxonomy/fbecb772cba8a1cb2bb3ffb3102ed91fab5bc45a.png');

        $manager->persist($plMedia);
        $manager->flush();
        
        $this->addReference('lp-media', $plMedia);
    }
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}

