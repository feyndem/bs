<?php

namespace BiblioSights\BookBundle\DataFixtures\ORM;

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
        for ($i=1; $i<10; $i++)
        {
            $book = new Book();
            $manager->persist($book);
            
            for ($j=1; $j<10; $j++)
            {
                $num1 = mt_rand(-949042, 3375459);
                $num2 = mt_rand(4451692, 8057074);
                $point = new Point($num1, $num2);
                $marker = new Marker($book);
                $marker->setPoint($point);
                //$book->addMarker($marker);
                $manager->persist($marker); 
            }
            
            $manager->flush();
        }
    }
}