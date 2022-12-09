<?php

namespace App\Controller;

use App\Entity\AdLost;
use App\Form\AdLostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/ad/lost/add', name: 'adLost_add')]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adLost = new AdLost();
        $form = $this->createForm(AdLostType::class, $adLost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adLost);
        }
        return $this->render('ad_lost/add.html.twig', ['form' => $form->createView()]);
    }
}
