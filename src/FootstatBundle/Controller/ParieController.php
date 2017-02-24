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

   
}
