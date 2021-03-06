<?php

namespace BiblioSights\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BiblioSights\MarkerBundle\Entity\Marker;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @ORM\OneToMany(targetEntity="BiblioSights\BookBundle\Entity\ISBN", mappedBy="book")
     */
    private $ISBNs;
    
    /**
     * @ORM\ManyToMany(targetEntity="BiblioSights\BookBundle\Entity\Author", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="book_author")
     */
    private $authors;
    
    /**
     * @var smallint
     * @ORM\Column(name="published", type="smallint", nullable=true)
     */
    private $published;
    
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
        $this->ISBNs = new ArrayCollection();
        $this->authors = new ArrayCollection();
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

    /**
     * Add ISBNs
     *
     * @param \BiblioSights\BookBundle\Entity\ISBN $iSBNs
     * @return Book
     */
    public function addISBN(\BiblioSights\BookBundle\Entity\ISBN $iSBNs)
    {
        $this->ISBNs[] = $iSBNs;
    
        return $this;
    }

    /**
     * Remove ISBNs
     *
     * @param \BiblioSights\BookBundle\Entity\ISBN $iSBNs
     */
    public function removeISBN(\BiblioSights\BookBundle\Entity\ISBN $iSBNs)
    {
        $this->ISBNs->removeElement($iSBNs);
    }

    /**
     * Get ISBNs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getISBNs()
    {
        return $this->ISBNs;
    }

    /**
     * Set published
     *
     * @param integer $published
     * @return Book
     */
    public function setPublished($published = null)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return integer 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Add authors
     *
     * @param \BiblioSights\BookBundle\Entity\Author $authors
     * @return Book
     */
    public function addAuthor(\BiblioSights\BookBundle\Entity\Author $author)
    {
        $author->addBook($this);
        $this->authors[] = $author;
    
        return $this;
    }

    /**
     * Remove authors
     *
     * @param \BiblioSights\BookBundle\Entity\Author $authors
     */
    public function removeAuthor(\BiblioSights\BookBundle\Entity\Author $author)
    {
        $this->authors->removeElement($author);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    } 
}