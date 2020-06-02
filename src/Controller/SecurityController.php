<?php
namespace App\Controller;

use App\FormGenerator\LoginFormGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    /**
     * @Route("/login", name="app_login")
     *
     * @param Request $request
     * @param LoginFormGenerator $loginFormGenerator
     * @param AuthenticationUtils $authenticationUtils
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function login(Request $request, LoginFormGenerator $loginFormGenerator, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager)
    {
        $loginForm = $loginFormGenerator->generateForm()
            ->setAction($this->generateUrl('app_login'))
            ->setMethod(Request::METHOD_POST)
            ->getForm();

        $loginForm->handleRequest($request);

        $error = null;

        if($loginForm->isSubmitted()) {
            dd('de ce nu ajunge aici????');
            //$error = $authenticationUtils->getLastAuthenticationError();
        }

        return $this->render('security/login.html.twig', [
            'error' => $error,
            'subTitle' => 'Login',
            'searchForm' => $this->getSearchForm()->createView(),
            'loginForm' => $loginForm->createView(),
            'user' => null
        ]);
    }

    /**
     * @Route("/signup", name="app_signup")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function signup(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/signup.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'subTitle' => 'Signup',
            'searchForm' => $this->getSearchForm()->createView(),
            'user' => null
        ]);
    }
}
