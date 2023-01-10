<?php

namespace App\Controller;

use App\Repository\AdFindRepository;
use App\Repository\AdLostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AdLostRepository $adLostRepository, AdFindRepository $adFindRepository): Response
    {
        $adFind = $adFindRepository->findBy([], ['id' => "DESC"], 4);
        $adLost = $adLostRepository->findBy([], ['id' => "DESC"], 4);
        return $this->render('home/index.html.twig', [
            "adFind" => $adFind,
            "adLost" => $adLost
        ]);
    }

    #[Route('/ad', name: 'ad')]
    public function ad(): Response
    {
        return $this->render('home/ad.html.twig');
    }
}
