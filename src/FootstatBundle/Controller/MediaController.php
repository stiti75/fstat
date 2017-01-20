<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller {

    public function MediasAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Media');
        $medias = $repository->findAll();
        return $this->render('FootstatBundle:Default:Medias\Medias.html.twig', array('medias' => $medias));
    }
}
