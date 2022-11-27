<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function main(): Response
    {
        return $this->render('dashboard/main.html.twig');
    }

    #[Route('/apps', name: 'apps')]
    public function apps(): Response
    {
        return $this->render('dashboard/apps.html.twig');
    }

    #[Route('/ads', name: 'ads')]
    public function ads(): Response
    {
        return $this->render('dashboard/ads.html.twig');
    }

    #[Route('/user-settings', name: 'user-settings')]
    public function userSettings(): Response
    {
        return $this->render('dashboard/user-settings.html.twig');
    }
}