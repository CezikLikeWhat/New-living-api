<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Symfony\Controller;

use App\Core\Application\FormParser\FormParser;
use App\Core\Application\Query\DeviceQuery;
use App\Core\Infrastructure\Symfony\FormErrorCatcher;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\Exceptions\CannotRemoveDevice;
use App\Device\Application\UseCase\ChangeDeviceInformation\Command as ChangeDeviceInformationCommand;
use App\Device\Application\UseCase\DeleteDevice\Command;
use App\Device\Domain\DeviceType;
use App\Device\Domain\Exception\DeviceFeatureNotFound;
use App\Device\Domain\Exception\DeviceNotFound;
use App\Device\Domain\Exception\FeatureNotFound;
use App\Device\Domain\Exception\InvalidMACAddress;
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
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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

            try {
                $this->messageBus->dispatch($command);
            } catch (HandlerFailedException $e) {
                if ($e->getNestedExceptionOfClass(DeviceNotFound::class)) {
                    $this->addFlash('fail', 'Device not found!');
                }
                if ($e->getNestedExceptionOfClass(InvalidMACAddress::class)) {
                    $this->addFlash('fail', 'Invalid MAC address!');
                }

                return $this->render('Devices/device_info.html.twig', [
                    'deviceInformationForm' => $deviceInformationForm->createView(),
                    'deviceFeaturesForm' => $deviceFeaturesForm->createView(),
                    'device' => $device,
                ]);
            }

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

        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(InvalidMACAddress::class)) {
                $this->addFlash('fail', 'Invalid MAC address!');
            }
            if ($e->getNestedExceptionOfClass(FeatureNotFound::class)) {
                $this->addFlash('fail', 'Feature not found!');
            }

            return $this->redirectToRoute('devices');
        }

        $this->addFlash('success', 'Successfully added the device');

        return $this->redirectToRoute('devices');
    }

    #[Route('/device/delete/{id}', name: 'delete_device', methods: ['GET', 'DELETE'])]
    public function deleteDevice(string $id): Response
    {
        $command = new Command(
            Uuid4::fromString($id)
        );

        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(CannotRemoveDevice::class)) {
                $this->addFlash('fail', 'Can\'t remove device!');

                return $this->redirectToRoute('devices');
            }
        }

        $this->addFlash('success', 'Successful removal of the device');

        return $this->redirectToRoute('devices');
    }

    #[Route('/json/devices/{id}', name: 'get_devices_data', methods: ['GET'])]
    public function getDevicesData(string $id): Response
    {
        $systemIdentifier = Uuid4::fromString($id);
        $userDevices = $this->deviceQuery->getAllDevicesByUserId($systemIdentifier);

        return $this->json($userDevices, Response::HTTP_OK);
    }

    #[Route('/json/device/get/{id}', name: 'get_device_data', methods: ['GET'])]
    public function getDeviceData(string $id): Response
    {
        try {
            $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));
        } catch (DeviceNotFound|InvalidMACAddress $e) {
            return $this->json(['errors' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $this->json($device, Response::HTTP_OK);
    }

    #[Route('/json/device/change/information/{id}', name: 'change_device_information', methods: ['PUT'])]
    public function changeDeviceInformation(string $id, Request $request): Response
    {
        try {
            $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));
        } catch (DeviceNotFound|InvalidMACAddress $e) {
            return $this->json(['status' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $deviceInformationForm = $this->createForm(
            GeneralDeviceInformationFormType::class,
            options: [
                'device' => $device,
            ]
        );

        $requestContent = $request->request->all();
        $deviceInformationForm->submit($requestContent);

        if (!$deviceInformationForm->isValid()) {
            return $this->json(
                [
                    'errors' => FormErrorCatcher::getFormErrors($deviceInformationForm),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

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

        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(DeviceNotFound::class) ||
                $e->getNestedExceptionOfClass(InvalidMACAddress::class)
            ) {
                return $this->json(['status' => $e->getMessage()], Response::HTTP_CONFLICT);
            }
        }

        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }

    #[Route('/json/device/change/parameter/{id}', name: 'change_device_parameter', methods: ['PUT'])]
    public function changeDeviceParameter(string $id, Request $request): Response
    {
        try {
            $device = $this->deviceQuery->getDeviceInformationById(Uuid4::fromString($id));
        } catch (DeviceNotFound|InvalidMACAddress $e) {
            return $this->json(['status' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $deviceFeaturesForm = $this->createForm(
            DeviceFeaturesFormType::class,
            options: [
                'payload' => $device->payload,
            ]
        );

        $requestContent = $request->request->all();
        $deviceFeaturesForm->submit($requestContent);

        if (!$deviceFeaturesForm->isValid()) {
            return $this->json(
                [
                    'errors' => FormErrorCatcher::getFormErrors($deviceFeaturesForm),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var array<mixed> $formData */
        $formData = $deviceFeaturesForm->getData();

        $formParser = new FormParser(
            $this->deviceFeatureRepository,
            $this->featureRepository,
            $this->deviceRepository
        );

        try {
            $parameters = $formParser->parseChangeFeatureForm($device->id, $formData);
        } catch (DeviceFeatureNotFound|DeviceNotFound|FeatureNotFound $e) {
            return $this->json(['status' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $command = new \App\Core\Application\Message\ChangeParameter\Command($parameters);

        $this->messageBus->dispatch(
            $command,
            [new AmqpStamp('device.'.$device->macAddress)]
        );

        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }

    #[Route('/json/add/device/{id}', name: 'add_device_json', methods: ['POST'])]
    public function addDeviceJson(string $id, Request $request): Response
    {
        $systemIdentifier = UUid4::fromString($id);

        $addNewDeviceForm = $this->createForm(
            GeneralDeviceInformationFormType::class,
            options: [
                'device' => null,
            ]
        );

        $requestContent = $request->request->all();

        $addNewDeviceForm->submit($requestContent);

        if (!$addNewDeviceForm->isValid()) {
            return $this->json(
                [
                'errors' => FormErrorCatcher::getFormErrors($addNewDeviceForm),
            ],
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var array{
         *     deviceName: string,
         *     deviceType: DeviceType,
         *     deviceMacAddress: string
         * } $formData
         */
        $formData = $addNewDeviceForm->getData();

        $command = new \App\Device\Application\UseCase\AddDevice\Command(
            $systemIdentifier,
            $formData['deviceName'],
            $formData['deviceType']->value,
            $formData['deviceMacAddress']
        );

        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(InvalidMACAddress::class) ||
                $e->getNestedExceptionOfClass(FeatureNotFound::class)
            ) {
                return $this->json(['status' => $e->getMessage()], Response::HTTP_CONFLICT);
            }
        }

        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }

    #[Route('/json/device/delete/{id}', name: 'delete_device_json', methods: ['DELETE'])]
    public function deleteDeviceJson(string $id): Response
    {
        $command = new Command(
            Uuid4::fromString($id)
        );

        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            if ($e->getNestedExceptionOfClass(CannotRemoveDevice::class)) {
                return $this->json(['status' => $e->getMessage()], Response::HTTP_NOT_FOUND);
            }
        }

        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }
}
