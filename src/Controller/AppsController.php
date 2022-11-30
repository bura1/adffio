<?php

namespace App\Controller;

use App\Entity\App;
use App\Form\AppType;
use App\Repository\AppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class AppsController extends AbstractController
{
    #[Route('/apps', name: 'apps')]
    public function apps(Request $request, EntityManagerInterface $entityManager, AppRepository $appRepository): Response
    {
        $app = new App();
        $form = $this->createForm(AppType::class, $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $app = $form->getData();
            $app->setUser($this->getUser());

            $entityManager->persist($app);
            $entityManager->flush();

            return $this->redirectToRoute('apps');
        }

        $apps = $appRepository->findBy(['user' => $this->getUser()]);

        return $this->render('dashboard/apps.html.twig', [
            'form' => $form->createView(),
            'apps' => $apps
        ]);
    }

//    #[Route('/get-apps', name: 'get-apps')]
//    public function getApps(AppRepository $appRepository, SerializerInterface $serializer): JsonResponse
//    {
//        $apps = $appRepository->findBy(['user' => $this->getUser()]);
//
//        $json = $serializer->serialize($apps, 'json', ['groups' => ['app']]);
//
//        return new JsonResponse($json);
//    }
}