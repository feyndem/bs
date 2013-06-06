<?php
namespace BiblioSights\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('published', null, array(
            'label' => 'Primera edición',
            'required' => false
        ));
        $builder->add('ISBNs', 'collection', array (
            'type' => new ISBNType(),
            'by_reference' => false
        ));
        $builder->add('authors', 'collection', array (
            'type' => new AuthorType(),
            'by_reference' => false,
            'allow_add'    => true,
            'allow_delete'    => true,            
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
           'data_class' => 'BiblioSights\BookBundle\Entity\Book' 
        ));
    }
    
    public function getName() {  
        return 'Book';
    }
}