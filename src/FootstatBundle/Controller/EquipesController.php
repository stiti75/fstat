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
        $matches = $em->getRepository('FootstatBundle:Matches')->byChampionnat($championnat);
        return $this->render('FootstatBundle:Default:Championnats\Presentation.html.twig', array('equipes' => $equipes, 'matches' => $matches));
    }

    // Affichage détails d'une equipe
    public function EquipeAction($equipe) {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equip = $repository->find($equipe);
        $matchesdom = $em->getRepository('FootstatBundle:Matches')->findByEquipeDom($equipe);
        $matchesext = $em->getRepository('FootstatBundle:Matches')->findByEquipeExt($equipe);
        return $this->render('FootstatBundle:Default:Equipes\Presentation.html.twig', array('equip' => $equip, 'matchesdom' => $matchesdom, 'matchesext' => $matchesext));
    }
}
