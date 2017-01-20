<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FootstatBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class MatchesAdmin extends AbstractAdmin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('date')
            ->add('equipeDom','entity',array(
                'class'=> 'FootstatBundle\Entity\Equipes',                
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false
        ))
            ->add('score1')
            ->add('score2')
            ->add('equipeExt','entity',array(
                'class'=> 'FootstatBundle\Entity\Equipes',                
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false
        ))
            ->add('championnat','entity',array(
                'class'=> 'FootstatBundle\Entity\championnat',                
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false
        ))
        

            // if no type is specified, SonataAdminBundle tries to guess it
//            ->add('body')
//
//            // ...
       ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
       $datagridMapper
            ->add('date')
            ->add('equipeDom.nom')
            ->add('equipeExt.nom')
            ->add('championnat.nom') 
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('date')
            ->add('equipeDom.nom')
            ->add('score1')
            ->add('score2')
            ->add('equipeExt.nom')
            ->add('championnat.nom') 

       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('date')
            ->add('equipeDom.nom')
            ->add('score1')
            ->add('score2')
            ->add('equipeExt.nom')
            ->add('championnat.nom') 
       ;
    }
}
