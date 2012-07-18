<?php
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use BiblioSights\BookBundle\Entity\Book;
use BiblioSights\MarkerBundle\Entity\Marker;
use BiblioSights\MarkerBundle\Entity\Point\Point;

class book_basic implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $book = new Book();
        for ($i=1; $i<=10; $i++)
        {
            $point = new Point($i, $i+1);
            $marker = new Marker($book);
            $marker->setPoint($point);
            $book->addMarker($marker);
            $manager->persist($marker); 
        }
        $manager->persist($book);
        $manager->flush();
    }
}