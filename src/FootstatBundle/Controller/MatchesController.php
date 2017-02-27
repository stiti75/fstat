<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;

class MatchesController extends Controller {
    public function MatcheAction($matchid) {
        // ici on affiche le match
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Matches');
        $match = $repository->find($matchid);
        $dataEqdom = $this->GetStatEquipe($match->getEquipeDom());
        $dataEqext = $this->GetStatEquipe($match->getEquipeExt());
 
        return $this->render('FootstatBundle:Default:Matches\Presentation.html.twig', array('dataEqext' => $dataEqext, 'dataEqdom' => $dataEqdom,'match'=>$match));
    }
    
    public function TodayMatchesAction() {

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Matches');
        $matchday = $repository->byDate();
        $nextmatch = $repository->allNextmatch();
        return $this->render('FootstatBundle:Default:Home\Presentation.html.twig', array('matchday'=>$matchday, 'nextmatch' => $nextmatch));
    }
    public function GetStatEquipe($equipe){
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Equipes');
        $equip = $repository->find($equipe);
        $matchesdom = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeDom' => $equipe, 'type' => 0));
        $matchesext = $em->getRepository('FootstatBundle:Matches')->findBy(array('equipeExt' => $equipe, 'type' => 0));
        
        $DataEq['nom']= $equip->getNom();
        $DataEq['logo']= $equip->getMedia();
        $DataEq['classement']= $equip->getClassement();
        $DataEq['Dom_NbMatch']= count($matchesdom);
        $DataEq['Ext_NbMatch']= count($matchesext);
        $DataEq['nbVdom'] = 0;
        $DataEq['nbVext'] = 0;
        $DataEq['nbNdom'] = 0;
        $DataEq['nbNext'] = 0;
        $DataEq['nbDdom'] = 0;
        $DataEq['nbDext'] = 0;
        foreach ($matchesdom as $matchedom){
            $score1 = $matchedom->getScore1();
            $score2 = $matchedom->getScore2();
            if ($score1>$score2){
                $DataEq['nbVdom'] = $DataEq['nbVdom']+1;
            }   else if($score1<$score2){
                $DataEq['nbDdom'] = $DataEq['nbDdom']+1;
            } else {
                $DataEq['nbNdom'] = $DataEq['nbNdom']+1;
            }
        }
        foreach ($matchesext as $matcheext){
            $score1 = $matcheext->getScore1();
            $score2 = $matcheext->getScore2();
            if ($score1>$score2){
                $DataEq['nbDext'] = $DataEq['nbDext']+1;
            }   else if($score1<$score2){
                $DataEq['nbVext'] = $DataEq['nbVext']+1;
            } else {
                $DataEq['nbNext'] = $DataEq['nbNext']+1;
            }
        }
        $DataEq['listmatchesdom']= $matchesdom;
        $DataEq['listmatchesext']= $matchesext;
        return $DataEq;
    }
}


