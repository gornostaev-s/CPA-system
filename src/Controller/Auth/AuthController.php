<?php

namespace App\Controller\Auth;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController 
{
    public function __construct(private readonly UserService $userService)
    {
    }

    #[Route('/login', name: 'login_action')]
    public function login(AuthenticationUtils $authenticationUtils, UrlGeneratorInterface $urlGenerator): Response
    {
        if ($this->getUser()?->isAdmin()) {
            return $this->redirect($urlGenerator->generate('admin_dashboard'));
        }

        if ($this->getUser()?->isUser()) {
            return $this->redirect($urlGenerator->generate('user_dashboard'));
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return self::render('@auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/registration', name: 'registration_action')]
    public function registration(
        AuthenticationUtils $authenticationUtils,
        UrlGeneratorInterface $urlGenerator,
        Request $request
    ): Response
    {
        if ($request->isMethod('POST')) {
            $this->userService->makeAndAuthorize($request);
        }

        if ($this->getUser()?->isAdmin()) {
            return $this->redirect($urlGenerator->generate('admin_dashboard'));
        }

        if ($this->getUser()?->isUser()) {
            return $this->redirect($urlGenerator->generate('user_dashboard'));
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return self::render('@auth/registration.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'logout_action')]
    public function logout()
    {

    }
}

