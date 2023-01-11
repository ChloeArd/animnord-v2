<?php

namespace App\Controller;

use App\Entity\AdFind;
use App\Entity\AdLost;
use App\Entity\FavoriteFind;
use App\Entity\FavoriteLost;
use App\Entity\User;
use App\Repository\FavoriteFindRepository;
use App\Repository\FavoriteLostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteFindController extends AbstractController
{
    #[Route('/favorite/find/add/{user}/{adFind}', name: 'add_favorite_find')]
    public function addFavorite(User $user, AdFind $adFind, EntityManagerInterface $entityManager, FavoriteFindRepository $favoriteFindRepository): Response
    {
        $favoriteView = $favoriteFindRepository->findBy(["user_fk" => $user->getId(), "adFind_fk" => $adFind->getId()]);

        if (!$favoriteView) {
            $favoriteFind = new FavoriteFind();
            $favoriteFind
                ->setAdFindFk($adFind)
                ->setUserFk($user);

            $entityManager->persist($favoriteFind);
            $entityManager->flush();
        }

        $id = $adFind->getId();
        return $this->redirectToRoute("ad_lost_one", ["id" => $adFind->getId()]);
    }

    #[Route('/favorite/find/delete/{id}/', name: 'delete_favorite_find')]
    public function deleteFavorite(FavoriteFind $favoriteFind, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($favoriteFind);
        $entityManager->flush();

        return $this->redirectToRoute("ad_lost_one", ["id" => $favoriteFind->getAdFindFk()->getId()]);

    }
}
