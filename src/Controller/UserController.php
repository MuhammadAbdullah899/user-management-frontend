<?php

namespace App\Controller;

use App\Form\UserCreateForm;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/user")
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController
{
    /**
     * @Route("/list", name="user_list")
     * @param UserService $userService
     * @return Response
     */
    public function listAction(
        UserService $userService
    ): Response
    {
        $userToken = $this->validateUserToken();
        if ($userToken !== true) return $userToken;
        $response = $userService->getUsers();
        if ($response['code'] !== Response::HTTP_OK) {
            $this->addFlash("error", $response['message']);
            return $this->redirectToRoute("login");
        }
        return $this->render('user/list.html.twig', [
            'users' => $response['data']
        ]);
    }
    
    /**
     * @Route("/create", name="user_create")
     * @param Request $request
     * @param UserService $userService
     * @return Response
     */
    public function createAction(
        Request $request,
        UserService $userService
    ): Response
    {
        $form = $this->createForm(UserCreateForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $response = $userService->createUser($data);
            if ($response['code'] !== Response::HTTP_OK) {
                $this->addFlash('error',  $response['message']);
            } else {
                $this->addFlash('success',  'User has been created Successfully');
            }
            return $this->redirectToRoute('login');
        }
        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
