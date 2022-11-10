<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteLostController extends AbstractController
{
    #[Route('/favorite/lost', name: 'favoriteLost')]
    public function index(): Response
    {
        return $this->render('favorite_lost/index.html.twig', [
            'controller_name' => 'FavoriteLostController',
        ]);
    }
}
