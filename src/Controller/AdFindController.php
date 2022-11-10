<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdFindController extends AbstractController
{
    #[Route('/ad/find', name: 'adFind')]
    public function index(): Response
    {
        return $this->render('ad_find/index.html.twig', [
            'controller_name' => 'AdFindController',
        ]);
    }
}
