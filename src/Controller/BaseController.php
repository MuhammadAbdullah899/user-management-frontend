<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    
    /**
     * @return bool|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateUserToken()
    {
        if (empty($this->get('session')->get('access_token'))) {
            return $this->redirectToRoute("login");
        }
        
        return true;
    }
}
