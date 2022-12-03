<?php

namespace App\Controller;

use App\Entity\App;
use App\Form\AppType;
use App\Repository\AppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class AppsController extends AbstractController
{
    #[Route('/apps', name: 'apps')]
    public function apps(Request $request, EntityManagerInterface $entityManager, AppRepository $appRepository): Response
    {
        $app = new App();
        $app->setUser($this->getUser());

        $form = $this->createForm(AppType::class, $app);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $app = $form->getData();

            $entityManager->persist($app);
            $entityManager->flush();

            return $this->redirectToRoute('apps');
        }

        $apps = $appRepository->findBy(['user' => $this->getUser()]);

        $formValid = 'true';
        if ($form->isSubmitted() && !$form->isValid()) {
            $formValid = 'false';
        }

        return $this->render('dashboard/apps.html.twig', [
            'form' => $form->createView(),
            'apps' => $apps,
            'formValid' => $formValid
        ], new Response(null, $form->isSubmitted() && !$form->isValid() ? 422 : 200));
    }

    #[Route('/delete-app/{appId}', name: 'delete-app')]
    public function deleteApp($appId, AppRepository $appRepository, EntityManagerInterface $entityManager): Response
    {
        $app = $appRepository->findOneBy(['id' => $appId]);

        $entityManager->remove($app);
        $entityManager->flush();

        return new Response(null, 204);
    }
}