<?php

namespace BiblioSights\MarkerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;


class MarkerBundle extends Bundle
{
    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        Type::addType('point', 'BiblioSights\MarkerBundle\Doctrine\DBAL\Types\PointType');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'point');
    }
}
