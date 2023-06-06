<?php

namespace App\Managers;

use App\Entity\Flow;
use App\Entity\FlowSubscription;
use App\Entity\Lead;
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
        $subscriptions = $this->flowSubscriptionRepository->find(['flowId' => $lead->flow->getId()], [
            'leadsCount',
            'rate'
        ]);

        foreach ($subscriptions as $subscription) {
            /**
             * @var FlowSubscription $subscription
             */
            $subscriber = $subscription->getSubscriber();

            if ($subscriber->getBalance() - $subscription->getRate() >= 0) {
                $subscription->setLeadsCount($subscription->getLeadsCount() + 1);
                $lead->setBuyer($subscriber);
                $this->flowSubscriptionRepository->store($subscription);
            }
        }
    }
}