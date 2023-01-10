<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


#[isGranted('IS_AUTHENTICATED_FULLY')]
class UserController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

     #[Route('/myAd', name: 'my_ad')]
    public function myAd(): Response
    {
        return $this->render('user/myAd.html.twig');
    }

    #[Route('/myFavorites', name: 'favorites')]
    public function myFavorites(): Response
    {
        return $this->render('user/favorites.html.twig');
    }

    #[Route('/account/update/{id<\d+>}', name: 'user_update_info')]
    public function updateInfo(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash("success", "Vos informations personnelles ont bien été modifié !");
            return $this->redirectToRoute("account");
        }
        return $this->render('user/updateInfo.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/account/updatePassword/{id<\d+>}', name: 'user_update_password')]
    public function updatePassword(User $user, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $password1 = $user->getPassword();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            // verify actual password
            if (password_verify($password, $password1)) {
                $encodedPassword = $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );
                // update a new password
                $user->setPassword($encodedPassword);
                $entityManager->flush();
                $this->addFlash("success", "Votre mot de passe a bien été modifié !");
                return $this->redirectToRoute("app_logout");
            }
            else {
                $this->addFlash("error", "Votre mot de passe actuel ne correspond pas !");
            }
        }
        return $this->render('user/updatePassword.html.twig', ['form' => $form->createView()]);
    }

    // Delete a user by putting that he is no longer active
    #[Route('/account/delete/{id<\d+>}', name: 'user_delete')]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->request->get("deleteUser")) {
            $user->setActive(0);
            $entityManager->flush();
            return $this->redirectToRoute("app_logout");
        }
        return $this->render('user/delete.html.twig');
    }
}
