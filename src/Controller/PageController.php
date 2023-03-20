<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/{pageSlug}', name: 'render_page')]
    public function renderPage(\Symfony\Component\HttpFoundation\Request $request)
    {
           echo '<pre>';
           var_dump($request->get('pageSlug'));
           die;
    }
}