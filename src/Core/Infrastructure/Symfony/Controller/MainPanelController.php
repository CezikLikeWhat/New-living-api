<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Security\Infrastructure\Symfony\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class MainPanelController extends AbstractController
{
    #[Route('/', name:'load_main_panel', methods:['GET'])]
    public function loadMainPanel(#[CurrentUser] User $user): Response
    {
        return $this->render('main.html.twig');
    }

    #[Route('/profile', name:'user_profile', methods:['GET'])]
    public function userProfile(): Response
    {
        return $this->render('profile.html.twig');
    }
    #[Route('/devices', name:'devices', methods:['GET'])]
    public function devices(): Response
    {
        return $this->render('devices.html.twig');
    }
}