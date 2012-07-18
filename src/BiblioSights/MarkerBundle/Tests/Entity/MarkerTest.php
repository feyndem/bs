<?php

namespace BiblioSights\MarkerBundle\Tests\Entity;

require_once dirname(__DIR__).'/../../../../app/AppKernel.php';
use BiblioSights\MarkerBundle\Entity\Marker;
use BiblioSights\MarkerBundle\Entity\Point\Point;

class MarkerTest extends \PHPUnit_Framework_TestCase
{
    private $em;
    private $kernel;

    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();
        $this->em = $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
    
    public function testMarker()
    {
        
       $markers = $this->em->getRepository('MarkerBundle:Marker')->findAll(); 
       $book = $this->em->getRepository('BookBundle:Book')->findAll();
       $book = $book[0];
       $now = strtotime('now');
       foreach ($markers as $marker)
       {
           $this->assertEquals($book->getId(), $marker->getBook()->getId());
           $entity_date = $marker->getCreated()->getTimestamp();
           $this->assertGreaterThanOrEqual($entity_date, $now);
       }

    }
}
