<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Google;

use App\Core\Domain\Email;
use App\Core\Infrastructure\Symfony\Uuid4;
use App\Security\Infrastructure\Symfony\User\User;
use App\User\Application\UseCase\AddUser;
use App\User\Domain\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class GoogleAuthenticator extends OAuth2Authenticator implements AuthenticationEntryPointInterface
{
    /** @var string[] array */
    private array $roleAdminEmails;

    public function __construct(
        private readonly ClientRegistry $clientRegistry,
        private readonly RouterInterface $router,
        private readonly UserRepository $userRepository,
        private readonly MessageBusInterface $bus,
        string $roleAdminEmails,
    ) {
        /** @var string[] $decodedEmails */
        $decodedEmails = json_decode($roleAdminEmails, true, 512, JSON_THROW_ON_ERROR);
        $this->roleAdminEmails = $decodedEmails;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            '/login',
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    public function supports(Request $request): ?bool
    {
        return 'connect_google_check' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        /** @var AccessToken $accessToken */
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client): UserInterface {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                /** @var string $googleUserId */
                $googleUserId = $googleUser->getId();
                $googleFirstName = $googleUser->getFirstName() ?? 'John';
                $googleLastName = $googleUser->getLastName() ?? 'Doe';
                $googleEmail = $googleUser->getEmail() ?? 'john.doe@gmail.com';
                $roles = ['ROLE_USER'];

                $user = $this->userRepository->findByEmail(new Email($googleEmail));

                if (!$user) {
                    if (in_array($googleEmail, $this->roleAdminEmails, true)) {
                        $roles[] = 'ROLE_ADMIN';
                    }

                    $this->bus->dispatch(new AddUser\Command(
                        $googleUserId,
                        $googleFirstName,
                        $googleLastName,
                        $googleEmail,
                        null,
                        $roles
                    ));

                    $id = $this->userRepository->findByGoogleId($googleUserId)?->id();

                    return new User(
                        $id ?? Uuid4::generateNew(),
                        $googleUserId,
                        $googleEmail,
                        $roles
                    );
                }

                return new User(
                    $user->id(),
                    $user->googleIdentifier(),
                    $user->email(),
                    $user->roles(),
                );
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('load_main_panel'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'key' => $exception->getMessageKey(),
            'message' => $exception->getMessageData(),
        ], Response::HTTP_FORBIDDEN);
    }
}
