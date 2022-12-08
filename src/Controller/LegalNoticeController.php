<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    #[Route('/legal/notice', name: 'app_legal_notice')]
    public function index(): Response
    {
        return $this->render('legal_notice/index.html.twig');
    }
}
