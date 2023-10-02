<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Uid\Factory\UuidFactory;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly LoginFormAuthenticator $loginFormAuthenticator,
        private readonly UserAuthenticatorInterface $authenticator,
        private readonly UserPasswordHasherInterface $encoder,
        private readonly UuidFactory $uuidFactory,
    )
    {

    }

    /**
     * @param Request $request
     * @return User
     */
    public function makeAndAuthorize(Request $request): User
    {
        $user = User::make(
            $request->get('phone'),
            $request->get('email'),
            $request->get('name'),
        );

        $user->setTelegramKey($this->uuidFactory->randomBased()->create()->toBase32());
        $user->setPassword($this->encoder->hashPassword($user, $request->get('password')));
        $this->userRepository->save($user, true);
        $this->authenticate($user, $request);

        return $user;
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Passport
     */
    public function authenticate(User $user, Request $request): Passport
    {
        $this->authenticator->authenticateUser(
            $user,
            $this->loginFormAuthenticator,
            $request);

        return $this->loginFormAuthenticator->authenticate($request);
    }

    /**
     * @param User $user
     * @return void
     */
    public function store(User $user): void
    {
        $this->userRepository->save($user, true);
    }

    /**
     * @param User $user
     * @param int $mode
     * @return void
     */
    public function changeUserMode(User $user, int $mode): void
    {
        $user->setMode($mode);
        $this->userRepository->save($user, true);
    }

    /**
     * @param User $user
     * @param float $sum
     * @return float
     */
    public function upUserBalance(User $user, float $sum): float
    {
        $user->setBalance($user->getBalance() + $sum);

        return $user->getBalance();
    }

    /**
     * @param User $user
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool
     * @throws Exception
     */
    public function changePassword(UserInterface $user, string $oldPassword, string $newPassword): bool
    {
        if (!$this->encoder->isPasswordValid($user, $oldPassword)) {
            throw new Exception('Неверный пароль');
        }

        $user->setPassword($this->encoder->hashPassword($user, $newPassword));
        $this->userRepository->save($user, true);

        return true;
    }
}