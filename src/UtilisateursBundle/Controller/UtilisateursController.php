<?php

namespace UtilisateursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use FootstatBundle\Entity\Equipes;
use UtilisateursBundle\Entity\Utilisateurs;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UtilisateursController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        return $this->render('UtilisateursBundle:Default:index.html.twig',array(
            'user' => $user
        ));
    }
    public function AddequipeAction($id)
    {
        $utilis = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $equipe = $em->getRepository('FootstatBundle:Equipes')->find($id);
        $utilis->addEquipe($equipe);
        $em->persist($utilis);
        $em->flush();
        return $this->render('UtilisateursBundle:Default:index.html.twig');
    }
    public function RemoveequipeAction($id)
    {
        $utilis = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $equipe = $em->getRepository('FootstatBundle:Equipes')->find($id);
        $utilis->removeEquipe($equipe);
        $em->persist($utilis);
        $em->flush();
        return $this->render('UtilisateursBundle:Default:index.html.twig');
    }
    public function FavorisAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('UtilisateursBundle:Default:Favoris.html.twig', array(
            'user' => $user
        ));
    }
    public function MesequipesAction()
    {
        $user = $this->getUser();
        return $this->render('UtilisateursBundle:Default:Mesequipes.html.twig', array(
            'user' => $user
        ));
    }
    
}
