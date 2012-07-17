<?php

namespace BiblioSights\BookBundle\Tests\Entity;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';
use BiblioSights\MarkerBundle\Entity\Point\Point;
use BiblioSights\MarkerBundle\Entity\Marker;
use BiblioSights\BookBundle\Entity\Book;

class BookTest extends \PHPUnit_Framework_TestCase
{
    private $em;
    private $kernel;

    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();
        $this->em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    public function testBook()
    {
       $point = new Point(2, -3);
       $marker = new Marker(); 
       $book =  new Book();
       
       $marker->setPoint($point);
       $book->addMarker($marker);
       
       $this->em->persist($marker);
       $this->em->persist($book);
       $this->em->flush();
       
       $libros = $this->em->getRepository('BookBundle:Book')->findAll();
       // Comprobamos que sólo hay un punto, el que hemos creado
       $this->assertEquals(1, count($libros));
       
       $libro = $libros[0];
       $marcadores = $libro->getMarkers();
       
       $this->assertEquals(1, count($libros));
       
       foreach ($marcadores as $marcador)
       {
           $this->assertEquals(2, $marcador->getPoint()->getLat());
           $this->assertEquals(-3, $marcador->getPoint()->getLng());
       }
       
       $now = strtotime('now');
       $entity_date = $libro->getCreated()->getTimestamp();
       // Comprobamos que se ha introducido una fecha y que es menor o igual a la actual
       $this->assertGreaterThanOrEqual($entity_date, $now);
       //$update_now = new Date('now');
       //$libro->setUpdated($update_now);
       $entity_date = $libro->getUpdated()->getTimestamp();
       $this->assertGreaterThanOrEqual($entity_date, $now);
       
       $this->em->remove($marker);
       $this->em->remove($book);
       $this->em->flush();
       $libros = $this->em->getRepository('BookBundle:Book')->findAll();
       // Comprobamos que se ha vaciado la base de datos
       $this->assertEquals(0, count($libros));
    }
}
