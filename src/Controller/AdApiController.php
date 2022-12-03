<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\AppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdApiController extends AbstractController
{
    #[Route('/api/app/{appId}/ad', name: 'get-ad')]
    public function getAd($appId, AppRepository $appRepository, AdRepository $adRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $app = $appRepository->findOneBy(['id' => $appId]);
        $ad = $adRepository->findOneBy(['app' => $app, 'active' => true]);

        if (!$ad) {
            $return = [
                'name' => 'null',
                'message' => 'null',
                'url' => 'null',
                'image' => 'null'
            ];
        } else {
            $ad->setViews($ad->getViews() + 1);
            $entityManager->persist($ad);
            $entityManager->flush();

            $return = [
                'name' => $ad->getName(),
                'message' => $ad->getMessage(),
                'url' => $ad->getUrl(),
                'image' => $ad->getAdImage() ? $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/files/' . $ad->getAdImage()->getFilePath() : 'null'
            ];
        }

        return $this->json($return);
    }
}