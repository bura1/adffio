<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdImage;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Repository\AppRepository;
use App\Service\FileHelper;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AdsController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/ads', name: 'ads')]
    public function ads(Request $request, EntityManagerInterface $entityManager, AdRepository $adRepository, ValidatorInterface $validator, FileHelper $fileHelper, AppRepository $appRepository): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad, [
            'userId' => $this->getUser()->getId()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('image')->getData();
            $originalFilename = $uploadedFile->getClientOriginalName();

            $violations = $validator->validate(
                $uploadedFile,
                [
                    new File([
                        'maxSize' => '1M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ]
                    ])
                ]
            );

            if ($violations->count() > 0) {
                return $this->render('dashboard/ads.html.twig', [
                    'form' => $form->createView()
                ], new Response(null, 422));
            }

            $filename = $fileHelper->uploadAdImage($uploadedFile);

            $adImage = new AdImage();
            $adImage->setName($filename);
            $adImage->setOriginalName($originalFilename ?? $filename);
            $adImage->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
            $adImage->setSize($uploadedFile->getSize());
            $adImage->setUploadedAt(new \DateTimeImmutable("now"));

            $ad = $form->getData();
            $ad->setUser($this->getUser());
            $ad->setAdImage($adImage);
            $ad->setCreatedAt(new \DateTimeImmutable("now"));
            $ad->setClicks(0);
            $ad->setViews(0);
            $ad->setActive(true);

            $adImage->setAd($ad);

            $entityManager->persist($ad);
            $entityManager->persist($adImage);
            $entityManager->flush();

            return $this->redirectToRoute('ads');
        }

        $ads = $adRepository->findBy(['user' => $this->getUser()]);

        $appsList = $appRepository->getListOfUniqueUsersApps($this->getUser());

        return $this->render('dashboard/ads.html.twig', [
            'form' => $form->createView(),
            'ads' => $ads,
            'appsList' => $appsList
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/delete-ad/{adId}', name: 'delete-ad')]
    public function deleteAd($adId, AdRepository $adRepository, EntityManagerInterface $entityManager, FileHelper $fileHelper): Response
    {
        $ad = $adRepository->findOneBy(['id' => $adId]);
        $adImage = $ad->getAdImage();

        $entityManager->remove($ad);
        $entityManager->flush();

        $fileHelper->deleteFile($adImage->getFilePath());

        return new Response(null, 204);
    }
}
