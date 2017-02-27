<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Parie;
use FootstatBundle\Entity\Combine;
use FOS\UserBundle\Model\UserInterface;
use FootstatBundle\Entity\Matches;

class ParieController extends Controller {

    public function CombineAction($idmatch) {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            $combines = [];
        } else {
            $combines = $user->getCombines();
        }
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime();
        $match =$em->getRepository('FootstatBundle:Matches')->find($idmatch);
        $comb = new Combine;
        $comb->setDate($date);
        $comb->setSaved(0);
        $parie = new Parie;
        $parie->setCote("1");
        $parie->setMatch($match);
        $parie->setCombine($comb);
        $user->addCombine($comb);
        $em->persist($comb);
        $em->persist($parie);
        $em->persist($user);
        $em->flush();
        return $this->render('FootstatBundle:Default:Combine\Presentation.html.twig');
    }
    public function AddparieAction($idmatch) {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $combines = $user->getCombines();
        foreach ($combines as $combine) {
            if ($combine->getSaved() == 0) {
                $match =$em->getRepository('FootstatBundle:Matches')->find($idmatch);
                $parie = new Parie;
                $parie->setCote("1");
                $parie->setMatch($match);
                $parie->setCombine($combine);
                $em->persist($parie);
                $em->flush();
            }
        }
        return $this->render('FootstatBundle:Default:Combine\Presentation.html.twig');
    }
    public function RemoveopencmbAction() {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $combines = $user->getCombines();
        foreach ($combines as $combine) {
            if ($combine->getSaved() == 0) {
                $em->remove($combine); 
                $em->flush();
            }
        }
        return $this->render('FootstatBundle:Default:Combine\Presentation.html.twig');
    }
   
}
