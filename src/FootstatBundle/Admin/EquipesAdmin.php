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
use Sonata\AdminBundle\Route\RouteCollection;

class EquipesAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('allmatches', $this->getRouterIdParameter().'/allmatches');
        $collection->add('macthesEquipe', $this->getRouterIdParameter().'/macthesEquipe');

    }
    // Fields to be shown on create/edit forms
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom')
            ->add('championnat','entity',array(
                'class'=> 'FootstatBundle\Entity\championnat',                
                'property' => 'nom',
                'expanded' => false,
                'multiple' => false
        ))
            ->add('classement')
            ->add('lien')
            ->add('media','entity',array(
                'class'=> 'FootstatBundle\Entity\Media',                
                'property' => 'alt',
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
            ->add('nom') 
            ->add('championnat.nom')
       ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nom')
            ->add('championnat.nom')
            ->add('classement')
            ->add('lien')
            ->add('media.alt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))

       ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
           ->add('nom')
            ->add('championnat.nom')
            ->add('classement')
            ->add('lien')
            ->add('media.alt')
       ;
    }
    
}
