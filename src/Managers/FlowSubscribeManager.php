<?php

namespace App\Managers;

use App\Entity\Flow;
use App\Entity\FlowSubscription;
use App\Repository\FlowSubscriptionRepository;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class FlowSubscribeManager
{
    private UserInterface $user;

    public function __construct(
        private readonly FlowSubscriptionRepository $flowSubscriptionRepository,
    )
    {
    }

    /**
     * @param UserInterface $user
     * @param Flow $flow
     * @return bool
     */
    public function subscribeTo(UserInterface $user, Flow $flow): bool
    {
        if ($fs = $this->flowSubscriptionRepository->findOneBy([
            'subscriberId' => $user->getId(),
            'flowId' => $flow->getId(),
        ])) {
            throw new UnprocessableEntityHttpException('Вы уже подписаны на данный поток');
        }

        return $this->flowSubscriptionRepository->store(FlowSubscription::make($user, $flow));
    }

    /**
     * @param UserInterface $user
     * @param Flow $flow
     * @return bool
     */
    public function unsubscribeFrom(UserInterface $user, Flow $flow): bool
    {
        if (!$fs = $this->flowSubscriptionRepository->findOneBy([
            'subscriberId' => $user->getId(),
            'flowId' => $flow->getId(),
        ])) {
            throw new UnprocessableEntityHttpException('Вы уже отписаны от потока');
        }

        $this->flowSubscriptionRepository->remove($fs);

        return true;
    }

    /**
     * @param UserInterface $user
     * @return void
     */
    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }

    /**
     * @param int $flowId
     * @return bool
     */
    public function isSubscribed(int $flowId): bool
    {
        if ($this->flowSubscriptionRepository->findOneBy([
            'subscriberId' => $this->user->getId(),
            'flowId' => $flowId,
        ])) {
            return true;
        }

        return false;
    }
}