<?php

namespace App\Controller;

use App\Entity\AdLost;
use App\Entity\CommentLost;
use App\Form\CommentLostType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentLostController extends AbstractController
{
    #[Route('/ad/lost/{adLost}/comment', name: 'adLost_comment')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, AdLost $adLost, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $commentLost = new CommentLost();
        $form = $this->createForm(CommentLostType::class, $commentLost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentLost);

            date_default_timezone_set('Europe/Paris');
            $datetime = new \DateTime();
            $commentLost->setDate($datetime);

            $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
            $userAuthenticated = $userRepository->find($idUser);
            $commentLost->setUserFk($userAuthenticated);
            $commentLost->setAdLostFk($adLost);
            $commentLost->setArchive(0);
            $entityManager->flush();

            $this->addFlash("success", "Votre commentaire a bien été ajouté !");
            return $this->redirectToRoute("ad_lost_one", ["id" => $commentLost->getAdLostFk()->getId()]);
        }
        return $this->render('comment_lost/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/ad/lost/comment/edit/{id}', name: 'adLost_comment_edit')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(CommentLost $commentLost, Request $request, EntityManagerInterface $entityManager): Response
    {

        $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        if ($idUser == $commentLost->getUserFk()->getId()) {

            $date = $commentLost->getDate();

            $form = $this->createForm(CommentLostType::class, $commentLost);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentLost);
                $commentLost->setDate($date);
                $commentLost->setArchive(0);
                $entityManager->flush();

                $this->addFlash("success", "Le commentaire a été modifié !");
                return $this->redirectToRoute("ad_lost_one", ["id" => $commentLost->getAdLostFk()->getId()]);
            }
        }
        return $this->render('comment_lost/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/ad/lost/comment/delete/{id}', name: 'adLost_comment_archive')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function archive(CommentLost $commentLost, EntityManagerInterface $entityManager): Response
    {
                $entityManager->persist($commentLost);
                $commentLost->setArchive(1);
                $entityManager->flush();
                $this->addFlash("success", "Le commentaire a été modifié !");
                return $this->redirectToRoute("ad_lost_one", ["id" => $commentLost->getAdLostFk()->getId()]);
    }

    #[isGranted('ROLE_ADMIN')]
    #[Route('/ad/lost/comment/deleteAdmin/{id}/', name: 'adLost_comment_delete')]
        public function deleteFavorite(CommentLost $commentLost, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($commentLost);
        $entityManager->flush();
        $this->addFlash("success", "Le commentaire a été supprimé !");
        return $this->redirectToRoute("ad_lost_one", ["id" => $commentLost->getAdLostFk()->getId()]);
    }
}
