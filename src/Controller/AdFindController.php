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

    // one ad find
    #[Route('/ad/find/{id<\d+>}', name: 'ad_find_one')]
    public function oneAdLost(AdFind $adFind, CommentFindRepository $commentFindRepository, FavoriteFindRepository $favoriteFindRepository): Response
    {
        if($adFind->getUserFk()->isActive() != 0) {
            $comments = $commentFindRepository->findBy(['adFind_fk' => $adFind->getId()]);
            $favorite = $favoriteFindRepository->findBy(['adFind_fk' => $adFind->getId()]);
        }
        else {
            return $this->redirectToRoute("home");

        }
        return $this->render('ad_find/one.html.twig', [
            "ad" => $adFind,
            "comments" => $comments,
            "favorite" => $favorite
        ]);
    }

    // edit a ad find and update a picture or delete
    #[Route('/ad/find/edit/{id<\d+>}', name: 'adFind_edit')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(AdFind $adFind, Request $request, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $id = $adFind->getId();
        $originalFilename = $adFind->getPicture();
        $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        if ($idUser == $adFind->getUserFk()->getId()) {

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

                    if ($originalFilename !== null) {
                        //delete a original picture
                        unlink($this->getParameter('picture_directory_local_find') . "/" . $originalFilename);
                    }
                    //upload a picture
                    $filePicture = $form->get('picture')->getData();
                    $filename = uniqid() . "." . $filePicture->guessExtension();

                    $filePicture->move(
                        $this->getParameter('picture_directory_local_find'),
                        $filename
                    );
                    $adFind->setPicture($filename);
                }
                else {
                    $adFind->setPicture($originalFilename);
                }

                $entityManager->flush();
                $this->addFlash("success", "L'annonce a bien été modifiée !");
                return $this->redirect("/ad/find/$id");
            }
        }
        else {
            return $this->redirect("/ad/find/$id");
        }
        return $this->render('ad_find/edit.html.twig', ['form' => $form->createView()]);
    }

    // delete a ad find and a picture
    #[Route('/ad/find/delete/{id<\d+>}', name: 'adFind_delete')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(AdFind $adFind, EntityManagerInterface $entityManager): Response
    {
        $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        if ($idUser == $adFind->getUserFk()->getId()) {
            //delete a picture
            $filePicture = $adFind->getPicture();

            unlink($this->getParameter('picture_directory_local_find') . "/" . $filePicture);

            $entityManager->remove($adFind);
            $entityManager->flush();

            $this->addFlash("success", "L'annonce a bien été supprimée !");
            return $this->redirectToRoute("account");
        }
        return $this->redirectToRoute("home");
    }
}
