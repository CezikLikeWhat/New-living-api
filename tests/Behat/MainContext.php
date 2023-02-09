<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Core\Domain\Clock;
use App\Core\Domain\Clock\TestClock;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Device\Application\UseCase\AddDevice\Command as AddDeviceCommand;
use App\Device\Application\UseCase\AddDeviceFeature\Command as AddDeviceFeatureCommand;
use App\Device\Application\UseCase\AddFeature\Command as AddFeatureCommand;
use App\User\Application\UseCase\AddUser\Command as AddUserCommand;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Coduo\PHPMatcher\PHPMatcher;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Defines application features from the specific context.
 */
class MainContext implements Context
{
    private Response $lastResponse;
    private ?KernelBrowser $client;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param TestClock $clock
     */
    public function __construct(
        private readonly KernelInterface $kernel,
        private readonly Clock $clock,
        private readonly MessageBusInterface $messageBus,
    ) {
        $this->client = $this->kernel->getContainer()->get('test.client');
    }

    /**
     * @BeforeScenario
     */
    public function clearDatabase(): void
    {
        /**
         * @var EntityManager $manager
         */
        $manager = $this->getDoctrine()->getManager();
        (new ORMPurger($manager))->purge();
    }

    private function getDoctrine(): Registry
    {
        return $this->getContainer()->get('doctrine');
    }

    private function getContainer(): ContainerInterface
    {
        return $this->kernel->getContainer()->get('test.service_container');
    }

    /**
     * @Given /^I have user in system$/
     */
    public function iHaveUserInSystem(): void
    {
        $command = new AddUserCommand(
            googleId: '104215204619508124589',
            firstName: 'Andrzej',
            lastName: 'Chodnikowski',
            email: 'andrzej.chodnikowski@gmail.com',
            userId: Uuid4::fromString('92e1b2c3-2c18-4698-a764-6d1a42f650f5'),
            roles: ['ROLE_USER']
        );

        $this->messageBus->dispatch($command);
    }

    /**
     * @Given I have a devices in system:
     *
     * @throws \JsonException
     * @throws Exception
     */
    public function iHaveADevicesInSystem(TableNode $table): void
    {
        foreach ($table->getHash() as $data) {
            $command = new AddDeviceCommand(
                Uuid4::fromString($data['user_id']),
                $data['name'],
                $data['device_type'],
                $data['mac_address'],
                Uuid4::fromString($data['id'])
            );
            $this->messageBus->dispatch($command);
        }
    }

    /**
     * @When I send :method request to :url with JSON headers and body:
     *
     * @throws \JsonException
     */
    public function iSendRequestToWithJsonHeaderAndBody(string $method, string $url, PyStringNode $string): void
    {
        $payload = json_decode($string->getRaw(), true, 512, JSON_THROW_ON_ERROR);

        $this->client->jsonRequest($method, $url, $payload);

        $this->lastResponse = $this->client->getResponse();
    }

    /**
     * @Then response status code should be :statusCode
     *
     * @throws Exception
     */
    public function responseStatusCodeShouldBe(int $statusCode): void
    {
        $responseStatusCode = $this->lastResponse->getStatusCode();
        if ($responseStatusCode !== $statusCode) {
            throw new Exception(sprintf('Status code is %s - something went wrong', $this->lastResponse->getStatusCode()));
        }
    }

    /**
     * @Then response payload should be json:
     *
     * @throws Exception
     */
    public function responsePayloadShouldBeJson(PyStringNode $jsonResponse): void
    {
        $matcher = new PHPMatcher();

        $match = $matcher->match($this->lastResponse->getContent(), $jsonResponse->getRaw());
        if (!$match) {
            throw new Exception(sprintf('Response does not match: %s', $matcher->error() ?? ''));
        }
    }

    /**
     * @When I send :requestMethod request to :apiUrl
     */
    public function iSendRequestTo(string $requestMethod, string $apiUrl): void
    {
        $headers = [];

        $this->client->request($requestMethod, $apiUrl, server: $headers);

        $this->lastResponse = $this->client->getResponse();
    }

    /**
     * @Given Today is :date
     *
     * @throws Exception
     */
    public function todayIs(string $date): void
    {
        $this->clock->setCurrentDateTime(DateTimeImmutable::createFromFormat('Y-m-d', $date));
    }

    /**
     * @Given /^I have a feature in system:$/
     */
    public function iHaveAFeatureInSystem(TableNode $table): void
    {
        foreach ($table->getHash() as $data) {
            $command = new AddFeatureCommand(
                $data['name'],
                $data['code_name'],
                $data['display_type'],
                Uuid4::fromString($data['feature_id'])
            );
            $this->messageBus->dispatch($command);
        }
    }

    /**
     * @Given /^I have a devices features in system:$/
     *
     * @throws \JsonException
     */
    public function iHaveADevicesFeaturesInSystem(TableNode $table): void
    {
        foreach ($table->getHash() as $data) {
            $command = new AddDeviceFeatureCommand(
                Uuid4::fromString($data['feature_id']),
                Uuid4::fromString($data['device_id']),
                json_decode($data['payload'], true, 512, JSON_THROW_ON_ERROR),
                Uuid4::fromString($data['id'])
            );
            $this->messageBus->dispatch($command);
        }
    }
}
