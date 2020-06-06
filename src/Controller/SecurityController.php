<?php
namespace App\Controller;

use App\Entity\User;
use App\FormGenerator\LoginFormGenerator;
use App\FormGenerator\SignupFormGenerator;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
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

        $lastError = $request->getSession()->get('auth_failed');
        $request->getSession()->remove('auth_failed');

        return $this->render('security/login.html.twig', [
            'error' => $lastError,
            'subTitle' => 'Login',
            'searchForm' => $this->getSearchForm()->createView(),
            'loginForm' => $loginForm->createView(),
            'user' => null
        ]);
    }

    /**
     * @Route("/signup", name="app_signup")
     *
     * @param Request $request
     * @param SignupFormGenerator $signupFormGenerator
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return Response
     */
    public function signup(Request $request, SignupFormGenerator $signupFormGenerator, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $signupForm = $signupFormGenerator->generateForm()
            ->setAction($this->generateUrl('app_signup'))
            ->setMethod(Request::METHOD_POST)
            ->getForm();

        $signupForm->handleRequest($request);

        if ($signupForm->isSubmitted()) {
            $data = $request->request->all()['form'];
            if (empty($data)) {
                $error = 'All inputs are required';
                return $this->renderForm($signupForm, $error);
            }

            if (empty($data['first_name'])) {
                $error = 'First name is required';
                return $this->renderForm($signupForm, $error);
            }

            if (empty($data['last_name'])) {
                $error = 'Last name is required';
                return $this->renderForm($signupForm, $error);
            }

            if (empty($data['email'])) {
                $error = 'Email is required';
                return $this->renderForm($signupForm, $error);
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $error = 'Email is invalid';
                return $this->renderForm($signupForm, $error);
            }

            if (empty($data['password1']) || empty($data['password2'])) {
                $error = 'Both password and password confirmation are required';
                return $this->renderForm($signupForm, $error);
            }

            if ($data['password1'] !== $data['password2']) {
                $error = 'Passwords must match';
                return $this->renderForm($signupForm, $error);
            }

            $existingUser = $this->getDoctrine()->getRepository('App:User')->findOneBy(['email' => $data['email']]);
            if (!empty($existingUser)) {
                $error = 'User with the specified email already exists';
                return $this->renderForm($signupForm, $error);
            }

            $user = new User();
            $hashedPassword = $passwordEncoder->encodePassword($user, $data['password1']);
            $user->setFirstName($data['first_name']);
            $user->setLastName($data['last_name']);
            $user->setEmail($data['email']);
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            // login the new user
            $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $loginFormAuthenticator, 'main');

            return new RedirectResponse('/');
        }

        return $this->renderForm($signupForm);
    }

    protected function renderForm($form, $error = null)
    {
        return $this->render('security/signup.html.twig', [
            'error' => $error,
            'subTitle' => 'Signup',
            'searchForm' => $this->getSearchForm()->createView(),
            'signupForm' => $form->createView(),
            'user' => null
        ]);
    }
}
