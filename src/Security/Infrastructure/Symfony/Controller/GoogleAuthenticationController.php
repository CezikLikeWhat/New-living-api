<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Symfony\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthenticationController extends AbstractController
{
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect(['profile', 'email', 'openid'], []);
    }

    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function checkConnection(Request $request, ClientRegistry $clientRegistry): void
    {
    }
}
