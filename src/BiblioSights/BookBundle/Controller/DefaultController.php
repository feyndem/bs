<?php

namespace BiblioSights\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($book)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $BookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id',$book);
        $Book = $BookQuery->getSingleResult();        
        return $this->render('BookBundle:Default:index.html.twig', array('book'=>$Book));
    }
}
