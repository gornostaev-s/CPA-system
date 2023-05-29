<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use App\Repository\FlowSubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: FlowSubscriptionRepository::class)]
class FlowSubscription
{
    use IdTrait;

    #[ORM\Column(name: 'subscriber_id', type: 'integer')]
    private int $subscriberId;

    #[ORM\Column(name: 'flow_id', type: 'integer')]
    private int $flowId;

    #[ORM\Column(name: 'leads_count', type: 'integer', options: ['default' => 0])]
    private int $leadsCount;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => 0.00])]
    private float $rate;

    #[ORM\ManyToOne(targetEntity: Flow::class)]
    #[ORM\JoinColumn(name: 'flow_id', referencedColumnName: 'id')]
    private Flow $flow;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'subscriber_id', referencedColumnName: 'id')]
    private User $subscriber;

    public function __construct()
    {
    }

    /**
     * @param User $user
     * @param Flow $flow
     * @param int $leadsCount
     * @return FlowSubscription
     */
    public static function make(UserInterface $user, Flow $flow, int $leadsCount = 0): FlowSubscription
    {
        $flowSubscription = new self;
        $flowSubscription->setFlow($flow);
        $flowSubscription->setSubscriber($user);
        $flowSubscription->setLeadsCount($leadsCount);
        $flowSubscription->setRate($flow->getRate());

        return $flowSubscription;
    }

    /**
     * @param Flow $flow
     */
    public function setFlow(Flow $flow): void
    {
        $this->flow = $flow;
    }

    /**
     * @return Flow
     */
    public function getFlow(): Flow
    {
        return $this->flow;
    }

    /**
     * @param User $subscriber
     */
    public function setSubscriber(User $subscriber): void
    {
        $this->subscriber = $subscriber;
    }

    /**
     * @return User
     */
    public function getSubscriber(): User
    {
        return $this->subscriber;
    }

    /**
     * @param int $leadsCount
     */
    public function setLeadsCount(int $leadsCount): void
    {
        $this->leadsCount = $leadsCount;
    }

    /**
     * @return int
     */
    public function getLeadsCount(): int
    {
        return $this->leadsCount;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }
}