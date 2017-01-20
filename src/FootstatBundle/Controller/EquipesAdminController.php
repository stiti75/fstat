<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesAdminController extends Controller {

    // Affichage page liste d'equipes d'une championnat
    public function ChampionnatAction($championnat) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equipes = $repository->byChampionnat($championnat);
        $matches = $em->getRepository('FootstatBundle:Matches')->byChampionnat($championnat);
        return $this->render('FootstatBundle:Admin:Championnats\listeEquipes.html.twig', array('equipes' => $equipes, 'matches' => $matches));
    }
    //request d'url    
    // recuperation des matches d'une équipe par URL
    Public function AllmatchAction($equipe) {
        $em = $this->getDoctrine()->getManager();
        $matchesdom = $em->getRepository('FootstatBundle:Matches')->findByEquipeDom($equipe);
        $matchesext = $em->getRepository('FootstatBundle:Matches')->findByEquipeExt($equipe);
        return $this->container->get('templating')->renderResponse('FootstatBundle:Admin:Equipes\listeMatches.html.twig', array('matchesdom' => $matchesdom, 'matchesext' => $matchesext));
    }
}
