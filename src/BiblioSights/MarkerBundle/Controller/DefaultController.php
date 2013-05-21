<?php

namespace BiblioSights\MarkerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BiblioSights\BookBundle\Entity\Book;
use BiblioSights\MarkerBundle\Entity\Marker;
use BiblioSights\MarkerBundle\Entity\Point\Point;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MarkerBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function newMarkerAction () {
        // Getting request and Doctrine manager
        $request = $this->getRequest(); 
        $em = $this->getDoctrine()->getManager();
        // Cheking for AJAX call
        if ($request->isXmlHttpRequest()) {
            // Checking if user is authenticated
            $securityContext = $this->container->get('security.context');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $user = $securityContext->getToken()->getUser();
                // Decode the request
                $data = json_decode($request->getContent());
                // Creating point from client data
                // Getting data
                $lat = $data->lat;
                $lng = $data->lng;
                // We need the book entity to create the related marker
                $book = $this->getDoctrine()->getRepository('BookBundle:Book')->find($data->bookid);
                // Creating point
                $point = new Point($lng, $lat);
                // Creating marker for the book
                $marker = new Marker($book);
                // Adding point to marker
                $marker->setPoint($point);
                $marker->setUser($user);
                $em->persist($marker);
                $em->flush();
                return $this->render('MarkerBundle:Default:addMarker.html.twig', array('request' => $data->bookid));             
            } else {
                return $this->render('MarkerBundle:Default:addMarkerError.html.twig');
            }
        } else {
            return $this->render('MarkerBundle:Default:addMarkerError.html.twig');        
        };
    }
}
