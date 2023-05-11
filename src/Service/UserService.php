<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly LoginFormAuthenticator $loginFormAuthenticator,
        private readonly UserAuthenticatorInterface $authenticator,
        private readonly UserPasswordHasherInterface $encoder,
    )
    {

    }

    public function makeAndAuthorize(Request $request): User
    {
        $user = User::make(
            $request->get('phone'),
            $request->get('email'),
            $request->get('name'),
        );

        $user->setPassword($this->encoder->hashPassword($user, $request->get('password')));
        $this->userRepository->save($user, true);
        $this->authenticate($user, $request);

        return $user;
    }

    public function authenticate(User $user, Request $request): Passport
    {
        $this->authenticator->authenticateUser(
            $user,
            $this->loginFormAuthenticator,
            $request);

        return $this->loginFormAuthenticator->authenticate($request);
    }

    public function store(User $user): void
    {
        $this->userRepository->save($user, true);
    }

    public function changeUserMode(User $user, int $mode): void
    {
        $user->setMode($mode);
        $this->userRepository->save($user, true);
    }
}