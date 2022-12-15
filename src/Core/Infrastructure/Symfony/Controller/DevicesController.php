<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\Query\DeviceQuery;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Security\Infrastructure\Symfony\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DevicesController extends AbstractController
{
    public function __construct(
        private readonly DeviceQuery $deviceQuery,
    ) {
    }

    #[Route('/devices', name: 'devices', methods: ['GET'])]
    public function devices(#[CurrentUser] User $user): Response
    {
        $userDevices = $this->deviceQuery->getAllDevicesByUserId($user->systemIdentifier());

        return $this->render('Devices/devices.html.twig', [
            'devices' => $userDevices,
        ]);
    }

    #[Route('/devices/{id}', name: 'specific_device', methods: ['GET'])]
    public function specificDevice(string $id, #[CurrentUser] User $user): Response
    {
        $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));

        return $this->render('Devices/device_info.html.twig', [
            'device' => $device,
        ]);
    }
}
