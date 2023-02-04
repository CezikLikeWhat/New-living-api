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
        return $this->render('application.html.twig');
    }

    #[Route('/json/application', name: 'get_application_data', methods: ['GET'])]
    public function getApplicationData(): Response
    {
        $aboutApplication = 'New Living is an open source application that allows users to easily add, remove and manage Smart House devices. The user, using RaspberryPi devices and Docker containers, is able to build an entire Smart House ecosystem, and from the web application is able to manage various device parameters such as bulb color or light animations or many more. The application is open source and open to expansion by users. Anyone who creates a Smart House module can share it with documentation with the rest of the community.';

        return $this->json(
            [
                'name' => 'New Living - API',
                'version' => '1.0.0',
                'licence' => 'MIT',
                'about' => $aboutApplication,
            ],
            Response::HTTP_OK
        );
    }
}
