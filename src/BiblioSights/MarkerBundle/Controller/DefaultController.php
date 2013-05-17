<?php

namespace BiblioSights\MarkerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MarkerBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function newMarkerAction () {
        $request = $this->getRequest();  
        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent());
            return $this->render('MarkerBundle:Default:addMarker.html.twig', array('request' => $data));  
        } else {
            return $this->render('MarkerBundle:Default:addMarkerError.html.twig');        
        };
    }
}
