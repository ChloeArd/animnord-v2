<?php

namespace App\Controller;

use App\Entity\AdFind;
use App\Entity\CommentFind;
use App\Form\CommentFindType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentFindController extends AbstractController
{
    #[Route('/ad/find/{adFind}/comment', name: 'adFind_comment')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function add(Request $request, AdFind $adFind, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $commentFind = new CommentFind();
        $form = $this->createForm(CommentFindType::class, $commentFind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentFind);

            date_default_timezone_set('Europe/Paris');
            $datetime = new \DateTime();
            $commentFind->setDate($datetime);

            $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
            $userAuthenticated = $userRepository->find($idUser);
            $commentFind->setUserFk($userAuthenticated);
            $commentFind->setAdFindFk($adFind);
            $commentFind->setArchive(0);
            $entityManager->flush();

            $this->addFlash("success", "Votre commentaire a bien été ajouté !");
            return $this->redirectToRoute("ad_find_one", ["id" => $commentFind->getAdFindFk()->getId()]);
        }
        return $this->render('comment_find/add.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/ad/find/comment/edit/{id}', name: 'adFind_comment_edit')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(CommentFind $commentFind, Request $request, EntityManagerInterface $entityManager): Response
    {

        $idUser = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        if ($idUser == $commentFind->getUserFk()->getId()) {

            $date = $commentFind->getDate();

            $form = $this->createForm(CommentFindType::class, $commentFind);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentFind);
                $commentFind->setDate($date);
                $commentFind->setArchive(0);
                $entityManager->flush();

                $this->addFlash("success", "Le commentaire a été modifié !");
                return $this->redirectToRoute("ad_find_one", ["id" => $commentFind->getAdFindFk()->getId()]);
            }
        }
        return $this->render('comment_find/edit.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/ad/find/comment/delete/{id}', name: 'adFind_comment_archive')]
    #[isGranted('IS_AUTHENTICATED_FULLY')]
    public function archive(CommentFind $commentFind, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($commentFind);
        $commentFind->setArchive(1);
        $entityManager->flush();
        $this->addFlash("success", "Le commentaire a été modifié !");
        return $this->redirectToRoute("ad_find_one", ["id" => $commentFind->getAdFindFk()->getId()]);
    }

    #[isGranted('ROLE_ADMIN')]
    #[Route('/ad/find/comment/deleteAdmin/{id}/', name: 'adFind_comment_delete')]
    public function deleteFavorite(CommentFind $commentFind, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($commentFind);
        $entityManager->flush();
        $this->addFlash("success", "Le commentaire a été supprimé !");
        return $this->redirectToRoute("ad_find_one", ["id" => $commentFind->getAdFindFk()->getId()]);
    }
}
