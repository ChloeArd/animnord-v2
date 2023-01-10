<?php

namespace App\Controller;

use App\Entity\AdFind;
use App\Form\AdFindType;
use App\Repository\AdFindRepository;
use App\Repository\CommentFindRepository;
use App\Repository\FavoriteFindRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdFindController extends AbstractController
{
    #[Route('/ad/find', name: 'adFind')]
    public function index(AdFindRepository $repository): Response
    {
        $all = $repository->findAll();
        return $this->render('ad_find/index.html.twig', [
            'ad_find' => $all,
        ]);
    }

    // add a ad find
    #[Route('/ad/find/add', name: 'adFind_add')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $adFind = new AdFind();
        $form = $this->createForm(AdFindType::class, $adFind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adFind);

            if ($form->get('color')->getData() === []) {
                $this->addFlash("error", "Veuillez choisir au moins une couleur !");
            }

            date_default_timezone_set('Europe/Paris');
            $datetime = new \DateTime();
            $adFind->setDate($datetime);

            $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
            $userAuthenticated = $repository->find($idUser);
            $adFind->setUserFk($userAuthenticated);

            if (!$form->get('picture')->isEmpty()) {
                //upload a picture
                $filePicture = $form->get('picture')->getData();
                $filename = uniqid() . "." . $filePicture->guessExtension();

                $filePicture->move(
                    $this->getParameter('picture_directory_local_find'),
                    $filename
                );
                $adFind->setPicture($filename);
            }

            $entityManager->flush();
            $this->addFlash("success", "Votre annonce a bien été crée, elle va être vérifié !");
            return $this->redirectToRoute("account");

        }
        return $this->render('ad_find/add.html.twig', ['form' => $form->createView()]);
    }

    // one ad lost
    #[Route('/ad/find/{id}', name: 'ad_find_one')]
    public function oneAdLost(AdFind $adFind, CommentFindRepository $commentFindRepository, FavoriteFindRepository $favoriteFindRepository): Response
    {
        $comments = $commentFindRepository->findBy(['adFind_fk' => $adFind->getId()]);
        $favorite = $favoriteFindRepository->findBy(['adFind_fk' => $adFind->getId()]);

        return $this->render('ad_find/one.html.twig', [
            "ad" => $adFind,
            "comments" => $comments,
            "favorite" => $favorite
        ]);
    }
}
