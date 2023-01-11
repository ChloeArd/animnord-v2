<?php

namespace App\Controller;

use App\Entity\AdLost;
use App\Entity\FavoriteLost;
use App\Entity\User;
use App\Repository\FavoriteLostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteLostController extends AbstractController
{

    #[Route('/favorite/lost/add/{user<\d+>}/{adLost<\d+>}', name: 'add_favorite_lost')]
    public function addFavorite(User $user, AdLost $adLost, EntityManagerInterface $entityManager, FavoriteLostRepository $favoriteLostRepository): Response
    {
        $favoriteView = $favoriteLostRepository->findBy(["user_fk" => $user->getId(), "adLost_fk" => $adLost->getId()]);

        if (!$favoriteView) {
            $favoriteLost = new FavoriteLost();
            $favoriteLost
                ->setAdLostFk($adLost)
                ->setUserFk($user);

            $entityManager->persist($favoriteLost);
            $entityManager->flush();
        }
        return $this->redirectToRoute("ad_lost_one", ["id" => $adLost->getId()]);
    }

    #[Route('/favorite/lost/delete/{id<\d+>}', name: 'delete_favorite_lost')]
    public function deleteFavorite(FavoriteLost $favoriteLost, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($favoriteLost);
        $entityManager->flush();
        return $this->redirectToRoute("ad_lost_one", ["id" => $favoriteLost->getAdLostFk()->getId()]);
    }
}
