<?php

namespace App\Controller;

use App\Entity\App;
use App\Form\AppType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function main(): Response
    {
        return $this->render('dashboard/main.html.twig');
    }

    #[Route('/user-settings', name: 'user-settings')]
    public function userSettings(): Response
    {
        return $this->render('dashboard/user-settings.html.twig');
    }
}