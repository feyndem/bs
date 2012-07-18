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
        $books = $this->em->getRepository('BookBundle:Book')->findAll();
        $this->assertEquals(1, count($books));
        foreach($books as $book)
        {
            $markers = $book->getMarkers();
            $i = 1;
            foreach ($markers as $marker)
            {
                $this->assertEquals($i, $marker->getPoint()->getLat());
                $this->assertEquals($i+1, $marker->getPoint()->getLng());
                $i++;
            }
        }
    }
}
