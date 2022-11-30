<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdsController extends AbstractController
{
    #[Route('/ads', name: 'ads')]
    public function ads(): Response
    {
        return $this->render('dashboard/ads.html.twig');
    }
}
