<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'load_application_panel', methods: ['GET'])]
    public function loadApplicationPanel(): Response
    {
        return $this->render('application.html.twig', [

        ]);
    }
}