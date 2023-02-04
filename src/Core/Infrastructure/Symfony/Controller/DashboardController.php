<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\Query\DeviceQuery;
use App\Core\Application\Query\UserQuery;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Security\Infrastructure\Symfony\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DashboardController extends AbstractController
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly DeviceQuery $deviceQuery,
    ) {
    }

    #[Route('/dashboard', name: 'load_dashboard', methods: ['GET'])]
    public function loadDashboard(#[CurrentUser] User $user): Response
    {
        $numberOfUserDevices = count($this->deviceQuery->getAllDevicesByUserId($user->systemIdentifier()));
        $mostPopularUserDevicesType = $this->deviceQuery->getMostPopularDeviceTypeByUserId($user->systemIdentifier());

        $numberOfUsersInSystem = $this->userQuery->getNumberOfAllUsers();
        $mostPopularDevicesTypeInSystem = $this->deviceQuery->getMostPopularDeviceType();

        return $this->render('Dashboard/dashboard.html.twig', [
            'userDevices' => [
                'icon' => 'fa-user',
                'name' => 'Number of your devices:',
                'amount' => $numberOfUserDevices,
            ],
            'mostPopularUserDevicesType' => [
                'icon' => 'fa-user',
                'name' => 'Your most popular device type:',
                'amount' => $mostPopularUserDevicesType,
            ],
            'numberOfUsers' => [
                'icon' => 'fa-computer',
                'name' => 'Number of users in system:',
                'amount' => $numberOfUsersInSystem,
            ],
            'mostPopularDevicesType' => [
                'icon' => 'fa-computer',
                'name' => 'Most popular device type in system',
                'amount' => $mostPopularDevicesTypeInSystem,
            ],
        ]);
    }

    #[Route('/json/dashboard/{id}', name: 'get_dashboard_data', methods: ['GET'])]
    public function getDashboardData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $numberOfUserDevices = count($this->deviceQuery->getAllDevicesByUserId($systemIdentifier));
        $mostPopularUserDevicesType = $this->deviceQuery->getMostPopularDeviceTypeByUserId($systemIdentifier);

        $numberOfUsersInSystem = $this->userQuery->getNumberOfAllUsers();
        $mostPopularDevicesTypeInSystem = $this->deviceQuery->getMostPopularDeviceType();

        return $this->json(
            [
            'numberOfUserDevices' => $numberOfUserDevices,
            'mostPopularUserDevicesType' => $mostPopularUserDevicesType,
            'numberOfUsersInSystem' => $numberOfUsersInSystem,
            'mostPopularDevicesTypeInSystem' => $mostPopularDevicesTypeInSystem,
        ],
            Response::HTTP_OK
        );
    }
}
