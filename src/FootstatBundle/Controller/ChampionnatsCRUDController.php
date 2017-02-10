<?php

namespace FootstatBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use FootstatBundle\Entity\Equipes;
use FootstatBundle\Entity\Matches;
use FootstatBundle\Entity\Media;

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
    function geturlhtml($url) {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'proxy' => 'tcp://10.158.10.16:8181',
            )
        );
        $context = stream_context_create($opts);
        $html = file_get_html($url, false, $context);
        return $html;
    }

    function getcontents($url) {
        $opts = array(
            'http' => array(
                'method' => "GET",
                'proxy' => 'tcp://10.158.10.16:8181',
            )
        );

        $context = stream_context_create($opts);
        $html = file_get_contents($url, false, $context);

        return $html;
    }

    // recuperation des equipes championnat par URL
    public function getallequipesAction($id) {
        $em = $this->getDoctrine()->getManager();
        $championnat = $em->getRepository('FootstatBundle:Championnat')->find($id);
        $html1 = $this->geturlhtml($championnat->getUrl());
        $html1 = $html1->find('tr[class=js-tr-hover]');
//        $html1 = $html1->find('span[class=team-label]');


        $i = 1;
        foreach ($html1 as $element) {

            $nom = $element->find('span[class=team-label]')[0]->plaintext;
            
            $nom = html_entity_decode($nom);
            $imgurl = 'http:' . $element->find('img')[0]->src;
            $imgurl = str_replace(' ', '%20', $imgurl);
            $imgurl = str_replace('-20', '-100', $imgurl);
            
//            file_put_contents('img/' . trim($nom) . '.gif', $this->getcontents($imgurl));
            $pts = $element->find('td[class=points]')[0]->plaintext;
            $jeu = $element->find('td[class=stat]')[0]->plaintext;
            $diff = $element->find('td[class=stat]')[6]->plaintext;

            $img = new Media();
            $img->setAlt(trim($nom));
            $img->setUrl(trim($nom) . '.gif');

//            $nom = str_replace('cuisine' ,'ê',$nom);

            $equipe = new Equipes();
            $lieneq = $element->find('a')[0]->href;
            $lieneq = "http://www.lequipe.fr" . $lieneq;
            

            $lequipe = $em->getRepository('FootstatBundle:Equipes')->findByNom($element->plaintext);
            if (!$lequipe) {
                $equipe->setLien($lieneq);
                $equipe->setNom($nom);
                $equipe->setClassement($i);
                $equipe->setJeu($jeu);
                $equipe->setPts($pts);
                $equipe->setDiff($diff);
                $equipe->setChampionnat($championnat);
                $equipe->setMedia($img);
                $em->persist($equipe);
                $em->flush();
            } else {
                $lequipe[0]->setClassement($i);
                $lequipe[0]->setJeu($jeu);
                $lequipe[0]->setPts($pts);
                $lequipe[0]->setDiff($diff);
                $em->persist($lequipe[0]);
                $em->flush();
            }
            $i = $i + 1;
        }
        return $this->ChampionnatAction($championnat);
    }

}
