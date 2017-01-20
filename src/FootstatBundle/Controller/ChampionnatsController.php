<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Championnat;
use FootstatBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class ChampionnatsController extends Controller {

    public function ChampionnatsAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Championnat');
        $championnats = $repository->findAll();
        return $this->render('FootstatBundle:Default:Championnats\Championnats.html.twig', array('championnats' => $championnats));
    }
    
    public function MenuAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Championnat');
        $championnats = $repository->findAll();
        return $this->render('FootstatBundle:Default:Championnats\Menu.html.twig', array('championnats' => $championnats));
    }
}
