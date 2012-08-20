<?php
/**
 * Description of MapExtension
 *
 * @author feyndem
 */
namespace BiblioSights\BookBundle\Twig\Extension;

class MapExtension extends \Twig_Extension 
{
    public function getName() 
    {
        return 'map';
    }
    
    public function getFunctions()
    {
        return array(
          'map_renderer' => new \Twig_Function_Method($this, 'mapRenderer'),  
        );
    }
    
    public function mapRenderer()
    {
        return 'ok';
    }
}
