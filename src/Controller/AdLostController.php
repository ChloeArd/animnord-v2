<?php

namespace App\Controller;

use App\Entity\AdLost;
use App\Entity\User;
use App\Form\AdLostType;
use App\Repository\AdLostRepository;
use App\Repository\CommentLostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdLostController extends AbstractController
{
    #[Route('/ad/lost', name: 'adLost')]
    public function index(AdLostRepository $repository): Response
    {
        $all = $repository->findAll();
        return $this->render('ad_lost/index.html.twig', [
            'ad_lost' => $all,
        ]);
    }

    #[Route('/ad/lost/{id}', name: 'ad_lost_one')]
    public function oneAdLost(AdLost $adLost, AdLostRepository $repository, CommentLostRepository $commentLostRepository): Response
    {
        $comments = $commentLostRepository->findBy(['adLost_fk' => $adLost->getId()]);
        return $this->render('ad_lost/one.html.twig', [
            "ad" => $adLost,
            "comments" => $comments
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/ad/lost/add', name: 'adLost_add')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $adLost = new AdLost();
        $form = $this->createForm(AdLostType::class, $adLost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adLost);

            if ($form->get('color')->getData() === []) {
                $this->addFlash("error", "Veuillez choisir au moins une couleur !");
            }

            date_default_timezone_set('Europe/Paris');
            $datetime = new \DateTime();
            $adLost->setDate($datetime);

            $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
            $userAuthenticated = $repository->find($idUser);
            $adLost->setUserFk($userAuthenticated);

            if (!$form->get('picture')->isEmpty()) {
                //upload a picture
                $filePicture = $form->get('picture')->getData();
                $filename = uniqid() . "." . $filePicture->guessExtension();

                $filePicture->move(
                    $this->getParameter('picture_directory_local_lost'),
                    $filename
                );
                $adLost->setPicture($filename);
            }

            $entityManager->flush();
            $this->addFlash("success", "Votre annonce a bien été crée, elle va être vérifié !");
            return $this->redirectToRoute("account");

        }
        return $this->render('ad_lost/add.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/ad/lost/edit/{id}', name: 'adLost_edit')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(AdLost $adLost, Request $request, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $id = $adLost->getId();
        $originalFilename = $adLost->getPicture();
        $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();

        if ($idUser == $adLost->getUserFk()->getId()) {

            $form = $this->createForm(AdLostType::class, $adLost);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($adLost);

                if ($form->get('color')->getData() === []) {
                    $this->addFlash("error", "Veuillez choisir au moins une couleur !");
                }

                date_default_timezone_set('Europe/Paris');
                $datetime = new \DateTime();
                $adLost->setDate($datetime);

                $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
                $userAuthenticated = $repository->find($idUser);
                $adLost->setUserFk($userAuthenticated);

                if (!$form->get('picture')->isEmpty()) {

                    if ($originalFilename !== null) {
                        //delete a original picture
                        unlink($this->getParameter('picture_directory_local_lost') . "/" . $originalFilename);
                    }
                    //upload a picture
                    $filePicture = $form->get('picture')->getData();
                    $filename = uniqid() . "." . $filePicture->guessExtension();

                    $filePicture->move(
                        $this->getParameter('picture_directory_local_lost'),
                        $filename
                    );
                    $adLost->setPicture($filename);
                }
                else {
                    $adLost->setPicture($originalFilename);
                }

                $entityManager->flush();
                $this->addFlash("success", "Votre annonce a bien été modifiée !");
                return $this->redirect("/ad/lost/$id");
            }
        }
        else {
            return $this->redirect("/ad/lost/$id");
        }
        return $this->render('ad_lost/edit.html.twig', ['form' => $form->createView()]);
    }

}
