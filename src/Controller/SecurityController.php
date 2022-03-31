<?php

namespace App\Controller;

use App\Service\ApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @param ApiService $apiService
     * @return Response
     */
    public function loginAction(
        Request $request,
        ApiService $apiService
    ): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        if ($request->getMethod() === 'POST' && !empty($email) && !empty($password)) {
           
            $response = $apiService->loginCall($email, $password);
            if (isset($response['code']) && $response['code'] !== Response::HTTP_OK) {
                $this->addFlash('error', $response['message']);
                return $this->redirect($this->generateUrl('login'));
            }
            return $this->redirect($this->generateUrl('user_list'));
        }
        return $this->render('security/login.html.twig');
    }
    
    /**
     * @Route("/logout", name="logout")
     * @param Request $request
     * @return Response
     */
    public function logoutAction(
        Request $request
    ): Response
    {
        $request->getSession()->clear();
        
        return $this->redirectToRoute('login');
    }
}
