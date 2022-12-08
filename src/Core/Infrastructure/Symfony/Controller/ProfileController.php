<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\Query\UserQuery;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Security\Infrastructure\Symfony\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    public function __construct(
        private readonly UserQuery $userQuery,
    ) {
    }

    #[Route('/profile', name: 'load_user_profile', methods: ['GET'])]
    public function loadUserProfile(#[CurrentUser] User $user): Response
    {
        $userInfo = $this->userQuery->getAllUserInformationsByUserId($user->systemIdentifier());
        $userDevices = $this->userQuery->getAllUserDevicesByUserId($user->systemIdentifier());

        return $this->render('Profile/profile.html.twig', [
            'user' => $userInfo,
            'userDevices' => $userDevices,
        ]);
    }

    #[Route('/profile/{id}', name: 'get_user_profile_data', methods: ['GET'])]
    public function getUserProfileData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $userInfo = $this->userQuery->getAllUserInformationsByUserId($systemIdentifier);
        $userDevices = $this->userQuery->getAllUserDevicesByUserId($systemIdentifier);

        return $this->json(
            [
                'user' => $userInfo,
                'userDevices' => $userDevices,
            ],
            Response::HTTP_OK
        );
    }
}
