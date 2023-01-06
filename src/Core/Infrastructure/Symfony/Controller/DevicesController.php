<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\FormParser\FormParser;
use App\Core\Application\Query\DeviceQuery;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\ChangeDeviceInformation\Command as ChangeDeviceInformationCommand;
use App\Device\Application\UseCase\DeleteDevice\Command;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Repository\DeviceFeatureRepository;
use App\Device\Domain\Repository\DeviceRepository;
use App\Device\Domain\Repository\FeatureRepository;
use App\Device\Infrastructure\Symfony\Forms\DeviceFeaturesFormType;
use App\Device\Infrastructure\Symfony\Forms\GeneralDeviceInformationFormType;
use App\Security\Infrastructure\Symfony\User\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DevicesController extends AbstractController
{
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceFeatureRepository $deviceFeatureRepository,
        private readonly FeatureRepository $featureRepository,
        private readonly DeviceQuery $deviceQuery,
        private readonly MessageBusInterface $messageBus,
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

    #[Route('/device/{id}', name: 'specific_device', methods: ['GET', 'POST'])]
    public function specificDevice(Request $request, string $id): Response
    {
        $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));

        $deviceInformationForm = $this->createForm(
            GeneralDeviceInformationFormType::class,
            options: [
                'device' => $device,
            ]
        );

        $deviceFeaturesForm = $this->createForm(
            DeviceFeaturesFormType::class,
            options: [
                'payload' => $device->payload,
            ]
        );

        $deviceInformationForm->handleRequest($request);
        $deviceFeaturesForm->handleRequest($request);

        if ($deviceInformationForm->isSubmitted() && $deviceInformationForm->isValid()) {
            /** @var array{
             *     deviceName: string,
             *     deviceType: DeviceType,
             *     deviceMacAddress: string,
             * } $formData
             */
            $formData = $deviceInformationForm->getData();
            $command = new ChangeDeviceInformationCommand(
                $device->id,
                $formData['deviceName'],
                $formData['deviceType']->value,
                $formData['deviceMacAddress']
            );
            $this->messageBus->dispatch($command);
            $this->addFlash('success', 'Successfully changed device data');
        }

        if ($deviceFeaturesForm->isSubmitted() && $deviceFeaturesForm->isValid()) {
            /** @var array<mixed> $formData */
            $formData = $deviceFeaturesForm->getData();

            $formParser = new FormParser(
                $this->deviceFeatureRepository,
                $this->featureRepository,
                $this->deviceRepository
            );

            $parameters = $formParser->parseChangeFeatureForm($device->id, $formData);

            $command = new \App\Core\Application\Message\ChangeParameter\Command($parameters);

            $this->messageBus->dispatch(
                $command,
                [new AmqpStamp('device.'.$device->macAddress)]
            );

            $this->addFlash('success', 'Successfully changed the parameters of the device');
        }

        return $this->render('Devices/device_info.html.twig', [
            'deviceInformationForm' => $deviceInformationForm->createView(),
            'deviceFeaturesForm' => $deviceFeaturesForm->createView(),
            'device' => $device,
        ]);
    }

    #[Route('/device/get/{id}', name: 'get_device_data', methods: ['GET'])]
    public function getDeviceData(string $id): Response
    {
        $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));

        return $this->json($device, Response::HTTP_OK);
    }

    #[Route('/add/device', name: 'add_device', methods: ['GET', 'POST'])]
    public function addDevice(#[CurrentUser] User $user, Request $request): Response
    {
        $addNewDeviceForm = $this->createForm(
            GeneralDeviceInformationFormType::class,
            options: [
                'device' => null,
            ]
        );

        $addNewDeviceForm->handleRequest($request);

        if (!$addNewDeviceForm->isSubmitted() || !$addNewDeviceForm->isValid()) {
            return $this->render('Devices/device_add.html.twig', [
                'addNewDeviceForm' => $addNewDeviceForm->createView(),
            ]);
        }

        /** @var array{
         *     deviceName: string,
         *     deviceType: DeviceType,
         *     deviceMacAddress: string
         * } $formData
         */
        $formData = $addNewDeviceForm->getData();

        $command = new \App\Device\Application\UseCase\AddDevice\Command(
            $user->systemIdentifier(),
            $formData['deviceName'],
            $formData['deviceType']->value,
            $formData['deviceMacAddress']
        );
        $this->messageBus->dispatch($command);

        $this->addFlash('success', 'Successfully added the device');

        return $this->redirectToRoute('devices');
    }

    #[Route('/device/delete/{id}', name: 'delete_device', methods: ['GET', 'DELETE'])]
    public function deleteDevice(string $id): Response
    {
        $command = new Command(
            Uuid4::fromString($id)
        );

        $this->messageBus->dispatch($command);
        $this->addFlash('success', 'Successful removal of the device');

        return $this->redirectToRoute('devices');
    }
}
