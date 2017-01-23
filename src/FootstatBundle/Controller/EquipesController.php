<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesController extends Controller {

    public function ChampionnatAction($championnat) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equipes = $repository->byChampionnat($championnat);
        $matcheslast = $em->getRepository('FootstatBundle:Matches')->findBy(array('championnat' => $championnat, 'type' => 0),array('date' => 'DESC'),10);
        $calmatches = $em->getRepository('FootstatBundle:Matches')->findBy(array('championnat' => $championnat, 'type' => 1),array('date' => 'ASC'),10);
        return $this->render('FootstatBundle:Default:Championnats\Presentation.html.twig', array('equipes' => $equipes, 'matches' => $matcheslast, 'calmatches' => $calmatches));
    }

    // Affichage détails d'une equipe
    public function EquipeAction($equipe) {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equip = $repository->find($equipe);
        $matchesdom = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeDom' => $equipe, 'type' => 0));
        $matchesext = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeExt' => $equipe, 'type' => 0));
        $nextmatchs = $em->getRepository('FootstatBundle:Matches')->byNextmatchs($equipe);
        return $this->container->get('templating')->renderResponse('FootstatBundle:Default:Equipes\Presentation.html.twig', array('equip' => $equip, 'matchesdom' => $matchesdom, 'matchesext' => $matchesext, 'nextmatchs' => $nextmatchs));
    }
}
