<?php

namespace Guide\CountrysBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        // return $this->render('base.html.twig');
        return $this->render('GuideCountrysBundle:Default:index.html.twig');
    }
}
