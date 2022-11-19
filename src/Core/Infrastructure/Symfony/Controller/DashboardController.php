<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route('/dashboard', name: 'load_dashboard', methods: ['GET'])]
    public function loadDashboard(): Response
    {
        return $this->render('dashboard.html.twig', [
        ]);
    }

    #[Route('/dashboard/{id}', name: 'get_dashboard_data', methods: ['GET'])]
    public function getDashboardData(): Response
    {
        return $this->json(
            [
            ],
            Response::HTTP_OK
        );
    }
}
