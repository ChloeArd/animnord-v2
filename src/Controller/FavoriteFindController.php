<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteFindController extends AbstractController
{
    #[Route('/favorite/find', name: 'favoriteFind')]
    public function index(): Response
    {
        return $this->render('favorite_find/index.html.twig', [
            'controller_name' => 'FavoriteFindController',
        ]);
    }
}
