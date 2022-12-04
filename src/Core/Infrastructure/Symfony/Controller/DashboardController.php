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

class DashboardController extends AbstractController
{
    public function __construct(
        private readonly UserQuery $userQuery
    ) {
    }

    #[Route('/dashboard', name: 'load_dashboard', methods: ['GET'])]
    public function loadDashboard(#[CurrentUser] User $user): Response
    {
        $numberOfUserDevices = count($this->userQuery->getAllUserDevicesByUserId($user->systemIdentifier()));
        $mostPopularUserDevicesType = $this->userQuery->getMostPopularUserDevicesType($user->systemIdentifier());

        $numberOfUsersInSystem = $this->userQuery->getNumberOfAllUsers();
        $mostPopularDevicesTypeInSystem = $this->userQuery->getMostPopularDevicesType();

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

    #[Route('/dashboard/{id}', name: 'get_dashboard_data', methods: ['GET'])]
    public function getDashboardData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $numberOfUserDevices = count($this->userQuery->getAllUserDevicesByUserId($systemIdentifier));
        $mostPopularUserDevicesType = $this->userQuery->getMostPopularUserDevicesType($systemIdentifier);

        $numberOfUsersInSystem = $this->userQuery->getNumberOfAllUsers();
        $mostPopularDevicesTypeInSystem = $this->userQuery->getMostPopularDevicesType();

        return $this->json([
            'numberOfUserDevices' => $numberOfUserDevices,
            'mostPopularUserDevicesType' => $mostPopularUserDevicesType,
            'numberOfUsersInSystem' => $numberOfUsersInSystem,
            'mostPopularDevicesTypeInSystem' => $mostPopularDevicesTypeInSystem
        ],
        Response::HTTP_OK
        );
    }
}
