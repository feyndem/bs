<?php
/**
 * GPoint: Point object for doctrine2 custom mapping type
 *
 * @author feyndem
 */
namespace BiblioSights\MarkerBundle\Entity\Point; 

class Point 
{
    /**
     * @var double $lat
     */
    private $lat;
    
    /**
     * @var double $lng
     */
    private $lng;
    
    /**
     * Getter for $lat
     * @return double
     */
    public function getLat()
    {
        return $this->lat;
    }
    
    /**
     * Getter for $lng
     * @return double
     */
    public function getLng()
    {
        return $this->lng;
    }
    
    /**
     * Setter for $lat
     * @param double $value
     */
    public function setLat($value)
    {
        $this->lat = $value;
    }
    
    /**
     * Setter for $lng
     * @param double $value
     */
    public function setLng($value)
    {
        $this->lng = $value;
    }
    
    /**
     * Constructor
     * @param double $lat
     * @param double $lng
     */
    public function __construct($lat=0, $lng=0)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
    
    public function __toString ()
    {
        return $this->lat.' '.$this->lng;
    }
}