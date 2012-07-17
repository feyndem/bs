<?php

namespace BiblioSights\MarkerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BiblioSights\MarkerBundle\Entity\Point\Point;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BiblioSights\MarkerBundle\Entity\Marker
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BiblioSights\MarkerBundle\Entity\MarkerRepository")
 */
class Marker
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
     * @var point $point
     *
     * @ORM\Column(name="point", type="point")
     */
    private $point;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @ORM\ManyToOne(targetEntity="BiblioSights\BookBundle\Entity\Book", inversedBy="markers")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    protected $book;
    
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
     * Set point
     *
     * @param point $point
     * @return Marker
     */
    public function setPoint(Point $point)
    {
        $this->point = $point;
    }

    /**
     * Get point
     *
     * @return point 
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set created
     *
     * @param datetime $created
     * @return Marker
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
     * Set book
     *
     * @param BiblioSights\BookBundle\Entity\Book $book
     * @return Marker
     */
    public function setBook(\BiblioSights\BookBundle\Entity\Book $book = null)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * Get book
     *
     * @return BiblioSights\BookBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }
}