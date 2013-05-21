<?php

namespace Bibliosights\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Bibliosights\UserBundle\Entity\User;

class user_basic implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null) 
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
        $user = new User;
        $clear_password = 'bsuser2';
        $salt = md5(time());
        
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
        $password = $encoder->encodePassword($clear_password, $salt);
        
        $user->setPassword($password);
        $user->setSalt($salt);
        $user->setEmail('mail2@bibliosights.com');
        $user->setRole('ROLE_USER');
        
        $manager->persist($user);
        $manager->flush();
    }
}

