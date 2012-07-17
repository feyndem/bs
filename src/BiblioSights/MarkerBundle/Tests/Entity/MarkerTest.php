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
       $marker = new Marker(); 
       $point = new Point(2.0001, 3.0002);
       $marker->setPoint($point);
       $this->em->persist($marker);
       $this->em->flush();
       $puntos = $this->em->getRepository('BiblioSightsMarkerBundle:Marker')->findAll();
       // Comprobamos que sólo hay un punto, el que hemos creado
       $this->assertEquals(1, count($puntos));
       
       $punto = $puntos[0];
       // comprobamos que los valores de lat y long han pasado bien a la BBDD
       $this->assertEquals(2.0001, $punto->getPoint()->getLat());
       $this->assertEquals(3.0002, $punto->getPoint()->getLng());
       
       $now = strtotime('now');
       $entity_date = $punto->getCreated()->getTimestamp();
       // Comprobamos que se ha introducido una fecha y que es menor o igual a la actual
       $this->assertGreaterThanOrEqual($entity_date, $now);

       $this->em->remove($marker);
       $this->em->flush();
       $puntos = $this->em->getRepository('BiblioSightsMarkerBundle:Marker')->findAll();
       // Comprobamos que se ha vaciado la base de datos
       $this->assertEquals(0, count($puntos));
    }
}
