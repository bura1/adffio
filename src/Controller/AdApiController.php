<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\AppRepository;
use Symfony\Component\Routing\Annotation\Route;

class AdApiController
{
    #[Route('/api/app/{appId}/ad', name: 'get-ad')]
    public function getAd($appId, AppRepository $appRepository, AdRepository $adRepository)
    {
        $app = $appRepository->findOneBy(['id' => $appId]);
        $ad = $adRepository->findOneBy(['app' => $app, 'active' => true]);

        dd($ad);
    }
}