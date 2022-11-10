<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentFindController extends AbstractController
{
    #[Route('/comment/find', name: 'commentFind')]
    public function index(): Response
    {
        return $this->render('comment_find/index.html.twig', [
            'controller_name' => 'CommentFindController',
        ]);
    }
}
