<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorPanelController extends AbstractController
{
    #[Route('/author', name: 'load_author_panel', methods: ['GET'])]
    public function loadAuthorPanel(): Response
    {
        return $this->render('author.html.twig');
    }

    #[Route('/json/author', name: 'get_author_data', methods: ['GET'])]
    public function getAuthorData(): Response
    {
        $authorAbout = "My name is Cezary Maćkowski. I'm a final year student in the field of engineering computer science at the Nicolaus Copernicus University in Torun. I have been working as a Backend/Cloud Developer at Iteo since March 2022. I work with technologies such as PHP(Symfony), Twig, Docker and Google Cloud Platform. I'm interested in cyber security, hacking, IoT (Internet of Things) and web technologies in general. In my free time I create projects based on Go and Python programming languages.";

        return $this->json(
            [
                'name' => 'Cezary Maćkowski',
                'about' => $authorAbout,
                'contact' => [
                    'github' => 'https://github.com/CezikLikeWhat',
                    'email' => 'cezarymackowski99@gmail.com',
                    'dockerhub' => 'https://hub.docker.com/u/cezarymackowski',
                    'linkedin' => 'https://www.linkedin.com/in/cezary-ma%C4%87kowski-662194223/',
                ],
            ],
            Response::HTTP_OK
        );
    }
}
