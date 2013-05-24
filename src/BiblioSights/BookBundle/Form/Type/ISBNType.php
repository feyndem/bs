<?php
namespace BiblioSights\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ISBNType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('ISBN13', null);
        $builder->add('ISBN10', null);
        $builder->add('Title', null);
        $builder->add('EditionYear', null);        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
           'data_class' => 'BiblioSights\BookBundle\Entity\ISBN' 
        ));
    }
    
    public function getName() {  
        return 'ISBN';
    }
}