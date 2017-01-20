<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class FavorisController extends Controller
{
    public function FavorisAction()
    {
        $session = $this->getRequest()->getSession();
        if (!$session->has('favoris')) $session->set('favoris', array());
        $favoris = $session->get('favoris');
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('FootstatBundle:Equipes')->findArray($favoris);
       
        return $this->render('FootstatBundle:Default:Favoris\Favoris.html.twig',array('equipes' => $equipes));
    }
    
    public function AjouterAction($id)
    {
  
//        $ideq = '';
//        $ideq = $request->request->get('ideq');
        $session = $this->getRequest()->getSession();
        if (!$session->has('favoris')) $session->set('favoris',array());
        $favoris = $session->get('favoris');
        array_push($favoris, intval($id));
  
            
//        $this->get('session')->getFlashBag()->add('success','Article ajouté avec succès');
        
            
        $session->set('favoris',$favoris);

        return $this->container->get('templating')->renderResponse('FootstatBundle:Default:Favoris\liste.html.twig');

        
//        return $this->redirect($this->generateUrl('Favoris'));
    }
    
    public function SupprimerAction($id)
    {
        $session = $this->getRequest()->getSession();
        $favoris = $session->get('favoris');
        var_dump($favoris);
        unset($favoris[array_search(intval($id), $favoris)]);
        var_dump($favoris);
        $session->set('favoris',$favoris);
        $this->get('session')->getFlashBag()->add('success','Equipe supprimée avec succès');


        return $this->redirect($this->generateUrl('Favoris')); 
    }
    
}
