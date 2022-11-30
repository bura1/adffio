<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdsController extends AbstractController
{
    #[Route('/ads', name: 'ads')]
    public function ads(Request $request, EntityManagerInterface $entityManager, AdRepository $adRepository): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ad = $form->getData();
            $ad->setUser($this->getUser());

            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('ads');
        }

        return $this->render('dashboard/ads.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
