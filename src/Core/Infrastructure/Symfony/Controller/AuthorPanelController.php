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
        return $this->render('author.html.twig', [

        ]);
    }
}