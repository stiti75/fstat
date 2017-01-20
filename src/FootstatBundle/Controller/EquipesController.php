<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

include_once 'Classe\simple_html_dom.php';

class EquipesController extends Controller {

    // Affichage page liste d'equipes d'une championnat
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
//        $formAlias = $this->createFormBuilder()
//                ->add('Charger les matches', 'submit', array('attr' => array('class' => 'btn btn-info')))
//                ->getForm();
//        $request = $this->get('request');
//        if ($request->getMethod() == 'POST') {
//            $this->Getallmatch($equip);
//            $request->getSession()
//                    ->getFlashBag()
//                    ->add('success', 'La liste des matches est chargée avec succès!')
//            ;
//        }
        
        return $this->render('FootstatBundle:Default:Equipes\Presentation.html.twig', array('equip' => $equip, 'matchesdom' => $matchesdom, 'matchesext' => $matchesext));
    }

    //request d'url    
    function geturlhtml($url){
     $opts = array(
         'http'=>array(
             'method'=>"GET",
             'proxy' => 'tcp://10.158.10.16:8181',
             )
         );

     $context = stream_context_create($opts);
     $html = file_get_html($url, false, $context);
     return $html;
 }

    //formulaire de generation d'equipes d'une championnat
 public function GenererAction() {
        // On récupère l'EntityManager
    $t_championnat = array('championnat' => null);
    $formAlias = $this->createFormBuilder($t_championnat)
    ->add('championnat', 'entity', array(
        'class' => 'FootstatBundle\Entity\Championnat',
        'property' => 'nom',
        'expanded' => false,
        'multiple' => false
        ))
    ->add('save', 'submit', array('attr' => array('class' => 'btn btn-info')))
    ->getForm();
    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
        $formAlias->handleRequest($request);
        if ($formAlias->isValid()) {
            $data = $formAlias->getData();
            $championnat = $data["championnat"];
            $this->getallequipe($championnat);
            $request->getSession()
            ->getFlashBag()
            ->add('success', 'La liste des équipes est chargée avec succès!')
            ;
        }
    }
    return $this->render('FootstatBundle:Default:Equipes\Add.html.twig', array('form' => $formAlias->createView(),
        ));
}

    // recuperation des equipes championnat par URL
private function getallequipe($championnat) {
    $em = $this->getDoctrine()->getManager();
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
    
}

    // recuperation des matches d'une équipe par URL
Public function AllmatchAction($equipe) {
    $em = $this->getDoctrine()->getManager();
    $equipe = $em->getRepository('FootstatBundle:Equipes')->find($equipe);
    
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
    $matchesdom = $em->getRepository('FootstatBundle:Matches')->findByEquipeDom($equipe);
    $matchesext = $em->getRepository('FootstatBundle:Matches')->findByEquipeExt($equipe);
    return $this->container->get('templating')->renderResponse('::modulesUsed\EqMatches.html.twig', array('matchesdom' => $matchesdom, 'matchesext' => $matchesext));
}




}
