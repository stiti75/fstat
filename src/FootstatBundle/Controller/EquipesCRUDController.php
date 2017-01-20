<?php

namespace FootstatBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesCRUDController extends CRUDController {


function geturlhtml($url){
     
     $html = file_get_html($url);
     return $html;
 }


Public function allmatchesAction($id) {
    $em = $this->getDoctrine()->getManager();
    $equipe = $em->getRepository('FootstatBundle:Equipes')->find($id);
    
    $html2 = $this->geturlhtml($equipe->getLien());
    $html2 = $html2->find('div[id=LASTMATCHS]')[0];
    foreach ($html2->find('tr[class=fc_match fc_code_CH]') as $element) {
        $match = new Matches();
        $datematch = $element->find('td[class=fc_m_date]')[0]->plaintext;
        $datematch = explode(" ", $datematch)[1];
        $datematch = \DateTime::createFromFormat('d/m/Y', $datematch);
        
        $equ1 = $element->find('td[class=fc_m_eq1]')[0];
        $equ2 = $element->find('td[class=fc_m_eq2]')[0];
        $resultat = $element->find('td')[3];
        $score1 = explode("-", $resultat->plaintext)[0];
        $score2 = explode("-", $resultat->plaintext)[1];
        if (trim($equipe->getNom()) == trim($equ1->plaintext)) {   
            $check = $em->getRepository('FootstatBundle:Matches')->findOneBy(array('date' => $datematch, 'equipeDom' => $equipe->getId()));
            if (!$check) {
                $match->setDate($datematch);
                $match->setEquipeDom($equipe);
                $equipe2 = $em->getRepository('FootstatBundle:Equipes')->findByNom($equ2->plaintext);    
                $match->setEquipeExt($equipe2[0]);
                $match->setChampionnat($equipe->getChampionnat());
                $match->setScore1((int) $score1);
                $match->setScore2((int) $score2);
                $em->persist($match);
                $em->flush();
            }
        } else {
            $check = $em->getRepository('FootstatBundle:Matches')->findOneBy(array('date' => $datematch, 'equipeExt' => $equipe->getId()));     
            if (!$check) {
                $match->setDate($datematch);
                $equipe2 = $em->getRepository('FootstatBundle:Equipes')->findByNom($equ1->plaintext);                  
                $match->setEquipeDom($equipe2[0]);
                $match->setEquipeExt($equipe);
                $match->setChampionnat($equipe->getChampionnat());
                $match->setScore1((int) $score1);
                $match->setScore2((int) $score2);
                $em->persist($match);
                $em->flush();
            }
            
        }
    }
   
    return $this->macthesEquipeAction($id);
}

public function macthesEquipeAction($equipe){

    $em = $this->getDoctrine()->getManager();
    $matchesdom = $em->getRepository('FootstatBundle:Matches')->findByEquipeDom($equipe);
    $matchesext = $em->getRepository('FootstatBundle:Matches')->findByEquipeExt($equipe);
    return $this->container->get('templating')->renderResponse('::modulesUsed\EqMatches.html.twig', array('matchesdom' => $matchesdom, 'matchesext' => $matchesext));
}
    

}