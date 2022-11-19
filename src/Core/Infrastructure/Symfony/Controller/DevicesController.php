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

class DevicesController extends AbstractController
{
    public function __construct(
        private readonly UserQuery $userQuery,
    ) {
    }

    #[Route('/devices', name: 'devices', methods: ['GET'])]
    public function devices(#[CurrentUser] User $user): Response
    {
        $userDevices = $this->userQuery->getAllUserDevicesByUserId($user->systemIdentifier());

        return $this->render('devices.html.twig', [
            'userDevices' => $userDevices
        ]);
    }

    #[Route('/devices/{id}', name: 'get_user_devices_data', methods: ['GET'])]
    public function getUserDevicesData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $userDevices = $this->userQuery->getAllUserDevicesByUserId($systemIdentifier);

        return $this->json(
            [
                'userDevices' => $userDevices
            ],
            Response::HTTP_OK
        );
    }
}