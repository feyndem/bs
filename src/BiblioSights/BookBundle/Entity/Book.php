<?php

namespace BiblioSights\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BiblioSights\MarkerBundle\Entity\Marker;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * BiblioSights\BookBundle\Entity\Book
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BiblioSights\BookBundle\Entity\BookRepository")
 */
class Book
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="BiblioSights\MarkerBundle\Entity\Marker", mappedBy="book")
     */
    private $markers;
    
     /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
     /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;
    
    public function __construct() 
    {
        $this->markers = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add markers
     *
     * @param BiblioSights\MarkerBundle\Entity\Marker $markers
     * @return Book
     */
    public function addMarker(\BiblioSights\MarkerBundle\Entity\Marker $markers)
    {
        $this->markers[] = $markers;
        return $this;
    }

    /**
     * Remove markers
     *
     * @param <variableType$markers
     */
    public function removeMarker(\BiblioSights\MarkerBundle\Entity\Marker $markers)
    {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return Book
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     * @return Book
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}