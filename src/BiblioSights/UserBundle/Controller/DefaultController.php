<?php

namespace BiblioSights\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use BiblioSights\UserBundle\Entity\User;
use BiblioSights\UserBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UserBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function loginAction ()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR, $session->get(SecurityContext::AUTHENTICATION_ERROR));
        
        return $this->render('UserBundle:Default:login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    public function loginBoxAction ()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR, $session->get(SecurityContext::AUTHENTICATION_ERROR));
        
        return $this->render('UserBundle:Default:loginBox.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    public function newAction (Request $request) 
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        
        if($request->isMethod('POST')) {
            $form->bind($request);
            if($form->isValid()) {
                
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setSalt(md5(time()));
                $codifiedPassword = $encoder->encodePassword(
                        $user->getPassword(),
                        $user->getSalt()
                        );
                $user->setPassword($codifiedPassword);
                $user->setRole('ROLE_USER');
                
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($user);
                $em->flush();
                return $this->redirect($this->generateUrl('home'));
            }
        }
        return $this->render('UserBundle:Default:new.html.twig', array('form' => $form->createView()));                        
    }
}
