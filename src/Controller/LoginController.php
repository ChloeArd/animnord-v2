<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {

        if ($this->getUser()) {
            $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
            // I check if the person has verified his account and if it is still active
            if($user->isVerified() !== false) {
                if ( $user->isActive() !== false) {
                    return $this->redirectToRoute('account');
                }
                else {
                    $this->addFlash("error", "Votre compte est inactif / supprimer !");
                    return $this->redirectToRoute("app_logout");
                }
            }
            else {
                $this->addFlash("error", "Vous n'avez pas valider votre compte sur le mail que vous avez reçu !");
                return $this->redirectToRoute("app_logout");
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void {}
}
