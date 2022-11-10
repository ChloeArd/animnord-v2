<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdLostController extends AbstractController
{
    #[Route('/ad/lost', name: 'adLost')]
    public function index(): Response
    {
        return $this->render('ad_lost/index.html.twig', [
            'controller_name' => 'AdLostController',
        ]);
    }
}
