<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Championnat;
use FOS\UserBundle\Model\UserInterface;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesController extends Controller {

    public function ChampionnatAction($championnat) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $favoris = [];
        } else {
            $favoris = $user->getEquipes();
        }
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $champio = $em->getRepository('FootstatBundle:Championnat')->find($championnat);
        $equipes = $repository->byChampionnat($championnat);
        $matcheslast = $em->getRepository('FootstatBundle:Matches')->findBy(array('championnat' => $championnat, 'type' => 0),array('date' => 'DESC'),10);
        $calmatches = $em->getRepository('FootstatBundle:Matches')->byNextmChamp($championnat);
        return $this->render('FootstatBundle:Default:Championnats\Presentation.html.twig', array('championnat' => $champio,'equipes' => $equipes, 'matches' => $matcheslast, 'calmatches' => $calmatches, 'Favoris' => $favoris));
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
