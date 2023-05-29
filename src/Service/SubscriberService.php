<?php

namespace App\Service;

use App\Entity\Flow;
use App\Entity\User;
use App\Managers\FlowSubscribeManager;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class SubscriberService
{
    public function __construct(
        private readonly UserRepository $subscriberRepository,
//        private readonly FlowRepository $flowRepository,
        private readonly FlowSubscribeManager $flowSubscribeManager,
    )
    {
    }

    public function findById(int $userId): User
    {
        return $this->subscriberRepository->findOneBy(['id' => $userId]);
    }

    /**
     * Подписать юзера на поток
     *
     * @param UserInterface $user
     * @param Flow $flow
     * @return bool
     */
    public function subscribeToFlow(UserInterface $user, Flow $flow): bool
    {
        return $this->flowSubscribeManager->subscribeTo($user, $flow);
    }

    /**
     * Отписать юзера от потока
     *
     * @param UserInterface $user
     * @param Flow $flow
     * @return bool
     */
    public function unsubscribeFromFlow(UserInterface $user, Flow $flow): bool
    {
        return $this->flowSubscribeManager->unsubscribeFrom($user, $flow);
    }
}