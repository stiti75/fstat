<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;
use Symfony\Component\HttpFoundation\Response;
include_once 'Classe\simple_html_dom.php';

class MatchesController extends Controller {
    public function MatcheAction($equipe) {
        // On récupère l'EntityManager
//        $em = $this->getDoctrine()->getManager();
//        $repository = $em->getRepository('FootstatBundle:Equipes');
//        $equip = $repository->find($equipe);
////        var_dump($equipe);
//        return $this->render('FootstatBundle:Default:Equipes\Presentation.html.twig', array('equip' => $equip));
    }
}


