<?php

namespace BiblioSights\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use BiblioSights\BookBundle\Util\Util;

/**
 * ISBN
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ISBN
{

    /**
     * @var string
     *
     * @ORM\Column(name="ISBN13", type="string", length=13)
     * @ORM\Id
     * @Assert\Length(
     *      min="13",
     *      max="13"
     * )
     */
    private $ISBN13;

    /**
     * @var string
     *
     * @ORM\Column(name="ISBN10", type="string", length=10, nullable=true)
     * @Assert\Length(
     *      min="10",
     *      max="10"
     * )
     */
    private $ISBN10;
    
    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $Title;
    
    /**
     * @ORM\Column(name="titleslug", type="string", length=255)
     */
    private $titleSlug;

    /**
     * @var smallint
     * @ORM\Column(name="EditionYear", type="smallint")
     * @Assert\Length(
     *      max="4"
     * ) 
     */
    private $EditionYear;

    /**
     * @var boolean
     * @ORM\Column(name="lead", type="boolean")
     * @Assert\NotNull()
     * @Assert\Type(type="bool")
     */
    private $lead;
    
    /**
     * @ORM\ManyToOne(targetEntity="BiblioSights\BookBundle\Entity\Book", inversedBy="ISBNs")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    protected $book;
    
    public function __construct(\BiblioSights\BookBundle\Entity\Book $book) 
    {
        $this->book = $book;
        $book->addISBN($this);
    }

    /**
     * Set ISBN13
     *
     * @param string $ISBN13
     * @return ISBN
     */
    public function setISBN13($ISBN13)
    {
        $this->ISBN13 = $ISBN13;
    
        return $this;
    }

    /**
     * Get ISBN13
     *
     * @return string 
     */
    public function getISBN13()
    {
        return $this->ISBN13;
    }

    /**
     * Set iSBN10
     *
     * @param string $ISBN10
     * @return ISBN
     */
    public function setISBN10($ISBN10)
    {
        $this->ISBN10 = $ISBN10;
    
        return $this;
    }

    /**
     * Get ISBN10
     *
     * @return string 
     */
    public function getISBN10()
    {
        return $this->ISBN10;
    }

    /**
     * Set book
     *
     * @param \BiblioSights\BookBundle\Entity\Book $book
     * @return ISBN
     */
    public function setBook(\BiblioSights\BookBundle\Entity\Book $book = null)
    {
        $this->book = $book;
    
        return $this;
    }

    /**
     * Get book
     *
     * @return \BiblioSights\BookBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set Title
     *
     * @param string $title
     * @return ISBN
     */
    public function setTitle($title)
    {
        $this->Title = $title;
        $this->titleSlug = Util::getSlug($this->Title);
    
        return $this;
    }

    /**
     * Get Title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * Set EditionYear
     *
     * @param integer $editionYear
     * @return ISBN
     */
    public function setEditionYear($editionYear)
    {
        $this->EditionYear = $editionYear;
    
        return $this;
    }

    /**
     * Get EditionYear
     *
     * @return integer 
     */
    public function getEditionYear()
    {
        return $this->EditionYear;
    }

    /**
     * Set lead
     *
     * @param boolean $lead
     * @return ISBN
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    
        return $this;
    }

    /**
     * Get lead
     *
     * @return boolean 
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * Set titleSlug
     *
     * @param string $titleSlug
     * @return ISBN
     */
    public function setTitleSlug($titleSlug)
    {
        $this->titleSlug = $titleSlug;
    
        return $this;
    }

    /**
     * Get titleSlug
     *
     * @return string 
     */
    public function getTitleSlug()
    {
        return $this->titleSlug;
    }
}