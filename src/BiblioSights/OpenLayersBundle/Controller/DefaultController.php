<?php

namespace BiblioSights\OpenLayersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OpenLayersBundle:Default:index.html.twig');
    }
}
