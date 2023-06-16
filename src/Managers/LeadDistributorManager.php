<?php

namespace App\Managers;

use App\Entity\FlowSubscription;
use App\Entity\Lead;
use App\Enum\LeadStatusEnum;
use App\Repository\FlowSubscriptionRepository;

class LeadDistributorManager
{
    public function __construct(
        private readonly FlowSubscriptionRepository $flowSubscriptionRepository,
    )
    {
    }

    public function apply(Lead $lead): void
    {
        $subscriptions = $this->flowSubscriptionRepository->findBy(['flowId' => $lead->getFlow()->getId()], [
            'leadsCount' => 'DESC',
            'rate' => 'DESC'
        ]);

        foreach ($subscriptions as $subscription) {
            /**
             * @var FlowSubscription $subscription
             */
            $subscriber = $subscription->getSubscriber();
            $lead->setFlowSubscription($subscription);

            if ($subscriber->getBalance() - $subscription->getRate() >= 0) {
                $subscription->setLeadsCount($subscription->getLeadsCount() + 1);
                $lead->setStatus(LeadStatusEnum::hold->value);
                $lead->setBuyer($subscriber);
                $this->flowSubscriptionRepository->store($subscription);
            }
        }
    }
}