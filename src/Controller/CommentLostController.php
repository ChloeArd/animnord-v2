<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentLostController extends AbstractController
{
    #[Route('/comment/lost', name: 'commentLost')]
    public function index(): Response
    {
        return $this->render('comment_lost/index.html.twig', [
            'controller_name' => 'CommentLostController',
        ]);
    }
}
