<?php

namespace FootstatBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class ChampionnatsCRUDController extends CRUDController {

    // Affichage page liste d'equipes d'une championnat
    public function ChampionnatAction($championnat) {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equipes = $repository->byChampionnat($championnat);
        $matches = $em->getRepository('FootstatBundle:Matches')->byChampionnat($championnat);
        return $this->render('FootstatBundle:Admin:Championnats\listeEquipes.html.twig', array('equipes' => $equipes, 'matches' => $matches));

    }
    //request d'url    
    function geturlhtml($url){
     $html = file_get_html($url);
     return $html;
 }


    // recuperation des equipes championnat par URL
 public function getallequipesAction($id) {
    $em = $this->getDoctrine()->getManager();
    $championnat = $em->getRepository('FootstatBundle:Championnat')->find($id);
    $html1 = $this->geturlhtml($championnat->getUrl());
    $html1 = $html1->find('span[class=team-label]');
    $i = 1;
    foreach ($html1 as $element) {
        $equipe = new Equipes();
        $lieneq = $element->find('a')[0]->href;
        $lieneq = "http://www.lequipe.fr" . $lieneq;

        $lequipe = $em->getRepository('FootstatBundle:Equipes')->findByNom($element->plaintext);
        if (!$lequipe) {
            $equipe->setLien($lieneq);
            $equipe->setNom($element->plaintext);
            $equipe->setClassement($i);
            $equipe->setChampionnat($championnat);
            $em->persist($equipe);
            $em->flush();
        } else {
            $lequipe[0]->setClassement($i);
            $em->persist($lequipe[0]);
            $em->flush();
        }
        $i = $i + 1;
    }
    return $this->ChampionnatAction($championnat);
}



}
