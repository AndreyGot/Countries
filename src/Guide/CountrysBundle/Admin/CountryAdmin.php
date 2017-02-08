<?php

namespace Guide\CountrysBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CountryAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('title', null, array('label' => 'Title'))
            ->add('text', null, array('label' => 'Text'))
        ;
    }
}