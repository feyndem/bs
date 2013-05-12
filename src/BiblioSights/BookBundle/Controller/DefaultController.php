<?php

namespace BiblioSights\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends Controller
{
    public function indexAction($book)
    {
        $em = $this->getDoctrine()->getManager();
        $BookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id',$book);
        $Book = $BookQuery->getSingleResult();        
        return $this->render('BookBundle:Default:index.html.twig', array('book'=>$Book));
    }
    
    public function homeAction()
    {
        return $this->render('BookBundle:Default:home.html.twig');
    }
    
    public function generateGeoJSONAction () 
    {
        $em = $this->getDoctrine()->getManager();
        $BookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id', 10);
        $Book = $BookQuery->getSingleResult();
        $container = $this->container;
        $serializer = $container->get('jms_serializer');
        $serialbook= $serializer->serialize($Book, "json");
        return new JsonResponse (array('book'=>$serialbook));
    }
}
