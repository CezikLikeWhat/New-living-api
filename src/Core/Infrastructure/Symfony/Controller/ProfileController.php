<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\Query\DeviceQuery;
use App\Core\Application\Query\UserQuery;
use App\Core\Infrastructure\Symfony\FormErrorCatcher;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Security\Infrastructure\Symfony\User\User;
use App\User\Application\UseCase\ChangeUserInformation\Command;
use App\User\Infrastructure\Symfony\Forms\GeneralProfileInformationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    public function __construct(
        private readonly UserQuery $userQuery,
        private readonly DeviceQuery $deviceQuery,
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/profile', name: 'load_user_profile', methods: ['GET', 'POST'])]
    public function loadUserProfile(Request $request, #[CurrentUser] User $user): Response
    {
        $userInfo = $this->userQuery->getAllUserInformationsByUserId($user->systemIdentifier());
        $userDevices = $this->deviceQuery->getAllDevicesByUserId($user->systemIdentifier());

        $generalProfileInformationForm = $this->createForm(
            GeneralProfileInformationFormType::class,
            options: [
                'userInfo' => $userInfo,
            ]
        );

        $generalProfileInformationForm->handleRequest($request);

        if (!$generalProfileInformationForm->isSubmitted() || !$generalProfileInformationForm->isValid()) {
            return $this->render('Profile/profile.html.twig', [
                'profileInformationForm' => $generalProfileInformationForm->createView(),
                'userDevices' => $userDevices,
            ]);
        }

        /** @var array{
         *     firstName: string,
         *     lastName: string,
         *     email: string
         * } $formData
         */
        $formData = $generalProfileInformationForm->getData();

        $command = new Command(
            $user->systemIdentifier(),
            $formData['firstName'],
            $formData['lastName'],
            $formData['email']
        );

        $this->messageBus->dispatch($command);

        $this->addFlash('success', 'Successfully changed your data');

        return $this->render('Profile/profile.html.twig', [
            'profileInformationForm' => $generalProfileInformationForm->createView(),
            'userDevices' => $userDevices,
        ]);
    }

    #[Route('/json/profile/change/{id}', name: 'change_user_profile_data', methods: ['PUT'])]
    public function changeUserProfileData(string $id, Request $request): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $userInfo = $this->userQuery->getAllUserInformationsByUserId($systemIdentifier);

        $generalProfileInformationForm = $this->createForm(
            GeneralProfileInformationFormType::class,
            options: [
                'userInfo' => $userInfo,
            ]
        );

        $requestContent = $request->request->all();
        $generalProfileInformationForm->submit($requestContent);

        if (!$generalProfileInformationForm->isValid()) {
            return $this->json(
                [
                    'errors' => FormErrorCatcher::getFormErrors($generalProfileInformationForm),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var array{
         *     firstName: string,
         *     lastName: string,
         *     email: string
         * } $formData
         */
        $formData = $generalProfileInformationForm->getData();

        $command = new Command(
            $systemIdentifier,
            $formData['firstName'],
            $formData['lastName'],
            $formData['email']
        );

        $this->messageBus->dispatch($command);

        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }

    #[Route('/json/profile/get/{id}', name: 'get_user_profile_data', methods: ['GET'])]
    public function getUserProfileData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $userInfo = $this->userQuery->getAllUserInformationsByUserId($systemIdentifier);
        $userDevices = $this->deviceQuery->getAllDevicesByUserId($systemIdentifier);

        return $this->json(
            [
                'user' => $userInfo,
                'userDevices' => $userDevices,
            ],
            Response::HTTP_OK
        );
    }
}
