<?php

namespace BiblioSights\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use BiblioSights\BookBundle\Entity\Book;
use BiblioSights\BookBundle\Entity\ISBN;
use BiblioSights\BookBundle\Entity\Author;
use BiblioSights\BookBundle\Form\Type\BookType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($book)
    {
        // Get the book from table
        $em = $this->getDoctrine()->getManager();
        if (is_numeric($book)) {
            $bookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id', $book);
        } elseif (is_string($book)) {
            $bookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b JOIN b.ISBNs i WHERE i.titleSlug = :titleSlug')->setParameter('titleSlug', $book);            
        }            
        $Book = $bookQuery->getSingleResult();
        // render template
        return $this->render('BookBundle:Default:index.html.twig', array('book'=>$Book));
    }
    
    public function homeAction()
    {
        return $this->render('BookBundle:Default:home.html.twig');
    }
    
    public function generateGeoJSONAction ($book) 
    {
        $em = $this->getDoctrine()->getManager();
        $BookQuery = $em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id', $book);
        $Book = $BookQuery->getSingleResult();
        $Book_Markers = $Book->getMarkers();
        $markers_array = array();
        foreach ($Book_Markers as $marker) {
            $point = $marker->getPoint();
            $marker_element["type"] = "Feature";
            $geometry = array();
            $geometry["type"] = "Point";
            $geometry["coordinates"] = array($point->getLat(), $point->getLng());
            $geometry["properties"]=array();            
            $marker_element["geometry"] = $geometry;
            $markers_array[] = $marker_element;
        };
        $result = array("type" => "FeatureCollection", "features" => $markers_array, "crs"=>array("type"=>"name", "properties"=>array("name"=>"urn:ogc:def:crs:OGC:1.3:CRS84")));
        $result_json = json_encode($result);
        $response = new Response($result_json,200,array('content-type' => 'application/json'));
        return $response;
    }
    
    public function newBookAction(Request $request) 
    {
        $book = new Book();
        $isbn = new ISBN($book);
        $author = new Author();
        $book->getAuthors()->add($author);
        $form = $this->createForm(new BookType(), $book);
        
        if($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $isbn->setLead(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($isbn);
                $em->persist($book);
                $em->flush();
                return $this->redirect($this->generateUrl('home'));
            }
        } else {
            return $this->render('BookBundle:Default:new.html.twig', array (
                'form' => $form->createView()
            ));
        }        
    }
}
