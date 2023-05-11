<?php

namespace App\Controller\Crm;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    #[Route('/dashboard/mode' , name: 'user_mode', methods: ['GET'])]
    public function mode(Request $request): RedirectResponse
    {
        $user = $this->getUser();
        $this->userService->changeUserMode($user, $request->get('type'));

        return $this->redirect($this->urlGenerator->generate('user_dashboard'));
    }
}