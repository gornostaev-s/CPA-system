<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController 
{ 
    #[Route('/login', name: 'loginAction')]
    public function loginAction(): Response
    { 
        return self::render('@auth/login.html.twig');


    }
}

