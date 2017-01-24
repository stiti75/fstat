<?php

namespace FootstatBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesCRUDController extends CRUDController {

    public function ChampionnatAction($championnat) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equipes = $repository->byChampionnat($championnat);
        $matches = $em->getRepository('FootstatBundle:Matches')->byChampionnat($championnat);
        return $this->render('FootstatBundle:Admin:Championnats\listeEquipes.html.twig', array('equipes' => $equipes, 'matches' => $matches));
    }
    
    
    
    function geturlhtml($url) {
  
        $html = file_get_html($url);
        return $html;
    }

    Public function allmatchesAction($id) {
        $em = $this->getDoctrine()->getManager();
        $equipe = $em->getRepository('FootstatBundle:Equipes')->find($id);

        $html2 = $this->geturlhtml($equipe->getLien());
//    $html2 = $html2->find('div[id=LASTMATCHS]')[0];
        foreach ($html2->find('tr[class=fc_match fc_code_CH]') as $element) {
            $match = new Matches();
            $datem = $element->find('td[class=fc_m_date]')[0]->plaintext;


            $equ1 = $element->find('td[class=fc_m_eq1]')[0];
            $equ1 = $equ1->plaintext;
            $equ1 = html_entity_decode($equ1);
            $equ2 = $element->find('td[class=fc_m_eq2]')[0];
            $equ2 = $equ2->plaintext;
            $equ2 = html_entity_decode($equ2);
            $resultat = $element->find('td')[3];

            if (trim($resultat->getAttribute("class")) == "fc_m_score fc_m_heure") {
                $type = 1;
                $score1 = "0";
                $score2 = "0";
                $datem = explode(" ", $datem)[1];
                $datematchs = $datem . " " . trim($resultat->plaintext);
                $datematch = \DateTime::createFromFormat('d/m/Y H:i', $datematchs);
            } else {
                $score1 = explode("-", $resultat->plaintext)[0];
                $score2 = explode("-", $resultat->plaintext)[1];
                $datematchs = explode(" ", $datem)[1]. " 00:00" ;
                $datematch = \DateTime::createFromFormat('d/m/Y H:i', $datematchs);
                $type = 0;
            }

            if (trim($equipe->getNom()) == trim($equ1)) {
                $check = $em->getRepository('FootstatBundle:Matches')->findOneBy(array('date' => $datematch, 'equipeDom' => $equipe->getId()));
                if (!$check) {
                    $match->setDate($datematch);
                    $match->setEquipeDom($equipe);
                    $equipe2 = $em->getRepository('FootstatBundle:Equipes')->findByNom($equ2);
                    $match->setEquipeExt($equipe2[0]);
                    $match->setChampionnat($equipe->getChampionnat());
                    $match->setScore1((int) $score1);
                    $match->setScore2((int) $score2);
                    $match->setType($type);
                    $em->persist($match);
                    $em->flush();
                }
            } else {
                $check = $em->getRepository('FootstatBundle:Matches')->findOneBy(array('date' => $datematch, 'equipeExt' => $equipe->getId()));
                if (!$check) {
                    $match->setDate($datematch);
                    $equipe2 = $em->getRepository('FootstatBundle:Equipes')->findByNom($equ1);
                    $match->setEquipeDom($equipe2[0]);
                    $match->setEquipeExt($equipe);
                    $match->setChampionnat($equipe->getChampionnat());
                    $match->setScore1((int) $score1);
                    $match->setScore2((int) $score2);
                    $match->setType($type);
                    $em->persist($match);
                    $em->flush();
                }
            }
        }

        return $this->macthesEquipeAction($id);
    }

    public function macthesEquipeAction($equipe) {

        $em = $this->getDoctrine()->getManager();
        $matchesdom = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeDom' => $equipe, 'type' => 0));
        $matchesext = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeExt' => $equipe, 'type' => 0));
        $nextmatchs = $em->getRepository('FootstatBundle:Matches')->byNextmatchs($equipe);
        return $this->container->get('templating')->renderResponse('FootstatBundle:Admin:Equipes\listeMatches.html.twig', array('matchesdom' => $matchesdom, 'matchesext' => $matchesext, 'nextmatchs' => $nextmatchs));
    }

}
