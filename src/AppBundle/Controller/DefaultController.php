<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {    
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

                return $this->redirectToRoute('backend');
            } 

            if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
                  
                return $this->redirectToRoute('platform');
            }

            throw new \LogicException("Unknow roles");            
        }

        return $this->redirectToRoute('login');
    }
}
