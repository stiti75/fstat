<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Championnat;
use FootstatBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class ChampionnatsController extends Controller {

    public function ChampionnatsAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Championnat');
        $championnats = $repository->findAll();
        

        return $this->render('FootstatBundle:Default:Championnats\Championnats.html.twig', array('championnats' => $championnats));
    }
    
    public function MenuAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Championnat');
        $championnats = $repository->findAll();

        return $this->render('FootstatBundle:Default:Championnats\Menu.html.twig', array('championnats' => $championnats));
    }

    public function AddAction(Request $request) {
        // On récupère l'EntityManager
        $championnat = new Championnat();
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder('form', $championnat);
        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
                ->add('nom', 'text')
                ->add('url', 'text')
                ->add('media','entity',array(
                    'class'=> 'FootstatBundle\Entity\Media',                
                    'property' => 'alt',
                    'expanded' => false,
                    'multiple' => false
            ))
                ->add('save', 'submit',array('attr'   =>  array('class'   => 'btn btn-info')))
                ;
        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();
        
        if ($form->handleRequest($request)->isValid()) {
            var_dump($championnat);
            $em = $this->getDoctrine()->getManager();
            $em->persist($championnat);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'image enregistrée.');
            return $this->redirect($this->generateUrl('Championnats', array('id' => $championnat->getId())));
        }
        
        return $this->render('FootstatBundle:Default:Championnats\Add.html.twig', array('form' => $form->createView(),
    ));
    }

}
//        $em = $this->getDoctrine()->getManager();

//        $media = new Media();
//        $media->setUrl("http://www.indir.com/logo/actual-coach-bundesliga.png");
//        $media->setAlt("Bundisliga");
//
//        $championnat = new Championnat();
//        $championnat->setNom("Bundisliga");
//        $championnat->setMedia($media);
//
//
//        // Étape 1 : On « persiste » l'entité
//
//        $em->persist($championnat);
//        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
//        // on devrait persister à la main l'entité $image
//        // $em->persist($image);
//        // Étape 2 : On déclenche l'enregistrement
//        $em->flush();