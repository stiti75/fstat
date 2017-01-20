<?php

namespace FootstatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FootstatBundle\Entity\Media;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller {

    public function MediasAction() {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('FootstatBundle:Media');
        $medias = $repository->findAll();

        return $this->render('FootstatBundle:Default:Medias\Medias.html.twig', array('medias' => $medias));
    }

    public function AddAction(Request $request) {
        // On récupère l'EntityManager
        $media = new Media();
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder('form', $media);
        // On ajoute les champs de l'entité que l'on veut à notre formulaire
        $formBuilder
                ->add('url', 'text')
                ->add('alt', 'text')
                ->add('save', 'submit',array('attr'   =>  array('class'   => 'btn btn-info')))
        ;
        // Pour l'instant, pas de candidatures, catégories, etc., on les gérera plus tard
        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();
        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($media);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'image enregistrée.');
            return $this->redirect($this->generateUrl('Medias', array('id' => $media->getId())));
        }

        return $this->render('FootstatBundle:Default:Medias\Add.html.twig', array('form' => $form->createView(),
        ));
    }

}
