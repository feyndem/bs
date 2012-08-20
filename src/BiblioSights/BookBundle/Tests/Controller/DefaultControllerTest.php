<?php

namespace BiblioSights\BookBundle\Tests\Controller;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';
use BiblioSights\MarkerBundle\Entity\Point\Point;
use BiblioSights\MarkerBundle\Entity\Marker;
use BiblioSights\BookBundle\Entity\Book;

class BookControllerTest extends \PHPUnit_Framework_TestCase
{
    private $em;
    private $kernel;

    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();
        $this->em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    public function testBookIndex()
    {
        $BookQuery = $this->em->createQuery('SELECT b FROM BookBundle:Book b WHERE b.id = :id')->setParameter('id',22);
        $Book = $BookQuery->getSingleResult();   
        $this->assertEquals(1, count($Book));
        $this->assertEquals(22, $Book->getId());        
    }
}
