<?php
namespace BiblioSights\MarkerBundle\Doctrine\DBAL\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use BiblioSights\MarkerBundle\Entity\Point\Point;


/**
 * PointType: Extiende AbstractType para crear un tipo reconocible por Doctrine
 * Spatial data POINT
 * @author feyndem
 */
class PointType extends Type 
{
    const POINT = 'point';
    
    public function getSQLDeclaration (array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'POINT';
    }
        
    public function getName ()
    {
        return self::POINT;
    }    
    public function canRequireSQLConversion()
    {
        return true;
    }
    
    public function convertToDatabaseValue ($value, AbstractPlatform $platform)
    {
        if ($value instanceof Point)
        {
            $value = pack('xxxxcLdd', '0', 1, $value->getLat(), $value->getLng());
        }
        return $value;
    }

    
    public function convertToPHPValue ($value, AbstractPlatform $platform)
    {
        $data = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $value);
        return new Point($data['lat'], $data['lon']);
    }
}
