<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPanelController extends AbstractController
{
    #[Route('/', name: 'load_main_panel', methods: ['GET'])]
    public function loadMainPanel(): Response
    {
        return $this->render('main.html.twig');
    }
}
