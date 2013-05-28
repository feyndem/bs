<?php
namespace BiblioSights\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ISBNType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('ISBN13', null, array(
            'label' => 'ISBN 13'
        ));
        $builder->add('ISBN10', null, array(
            'label' => 'ISBN 10'
        ));
        $builder->add('Title', null, array(
            'label' => 'Título'
        ));
        $builder->add('EditionYear', null, array(
            'label' => 'Año de edición'
        ));         
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