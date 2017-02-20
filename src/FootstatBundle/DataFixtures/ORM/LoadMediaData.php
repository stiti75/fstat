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
use FootstatBundle\Entity\Media;

class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $plMedia = new Media();
        $plMedia->setAlt('Premier League');
        $plMedia->setUrl('https://prod-slcontent.s3.amazonaws.com/photos-cache/taxonomy/fbecb772cba8a1cb2bb3ffb3102ed91fab5bc45a.png');
        
        $lgMedia = new Media();
        $lgMedia->setAlt('Laliga');
        $lgMedia->setUrl('https://lh3.googleusercontent.com/p0aA9x4H41Xc9AMVRW7Ssb3YcqG2tzcSZliUOi7aHxxJVa4k6LDllP7JFMKLmeobqYc=w300');
        
        $blMedia = new Media();
        $blMedia->setAlt('Bundisliga');
        $blMedia->setUrl('https://upload.wikimedia.org/wikipedia/fr/b/b4/Logo_Bundesliga.png');

        $manager->persist($lgMedia);
        $manager->persist($plMedia);
        $manager->persist($blMedia);
        $manager->flush();
        
        $this->addReference('lp-media', $plMedia);
        $this->addReference('lg-media', $lgMedia);
        $this->addReference('bl-media', $blMedia);
    }
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}

