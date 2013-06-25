<?php
namespace BiblioSights\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('email', 'email', array(
            'label' => 'email'
        ));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'label' => 'Password',
            'first_options' => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),            
            'invalid_message' => 'Las dos contraseñas deben coincidir'            
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
           'data_class' => 'BiblioSights\UserBundle\Entity\User' 
        ));
    }
    
    public function getName() {  
        return 'User';
    }
}
