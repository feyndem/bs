<?php

namespace BiblioSights\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $ISBN13;

    /**
     * @var string
     *
     * @ORM\Column(name="ISBN10", type="string", length=10, nullable=true)
     */
    private $ISBN10;
    
    /**
     * @ORM\ManyToOne(targetEntity="BiblioSights\BookBundle\Entity\Book", inversedBy="ISBNs")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    protected $book;
    
    public function __construct($ISBN13, \BiblioSights\BookBundle\Entity\Book $book) 
    {
        $this->ISBN13 = $ISBN13;
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
}