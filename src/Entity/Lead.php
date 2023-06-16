<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Enum\LeadStatusEnum;
use App\Factories\PhoneFactory;
use App\Repository\LeadRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: LeadRepository::class)]
#[ORM\Table(name: 'leads')]
class Lead
{
    use IdTrait;
    use CreatedAtTrait;

    /**
     * Идентификатор пользователя, который приобрел лид
     *
     * @var int|null
     */
    #[ORM\Column(name: 'buyer_id', type: 'integer', nullable: true)]
    private ?int $buyerId = 0;

    /**
     * Идентификатор пользователя, от лица которого был создан лид
     *
     * @var int
     */
    #[ORM\Column(name: 'owner_id', type: 'integer')]
    private int $ownerId;

    /**
     * Идентификатор подписки рекламодателя на поток
     *
     * @var int
     */
    #[ORM\Column(name: 'subscription_id', type: 'integer')]
    private int $subscriptionId;

    /**
     * Идентификатор выбранного потока
     *
     * @var int
     */
    #[ORM\Column(name: 'flow_id', type: 'integer')]
    private int $flowId;

    /**
     * Сущность подписки по которой создался лид
     *
     * @var FlowSubscription
     */
    #[ORM\ManyToOne(targetEntity: FlowSubscription::class)]
    #[ORM\JoinColumn(name: 'subscription_id', referencedColumnName: 'id')]
    private FlowSubscription $flowSubscription;

    /**
     * Сущность покупателя лида
     *
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'buyer_id', referencedColumnName: 'id', nullable: true)]
    private ?User $buyer = null;

    /**
     * Сущность продавца лида
     *
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'owner_id', referencedColumnName: 'id')]
    private User $owner;

    #[ORM\ManyToOne(targetEntity: Flow::class)]
    #[ORM\JoinColumn(name: 'flow_id', referencedColumnName: 'id')]
    private Flow $flow;

    /**
     * Дата и время доставки до покупателя лида
     *
     * @var DateTime|null
     */
    #[ORM\Column(name: 'delivered_at', type: 'datetime', nullable: true, options: ['default' => "CURRENT_TIMESTAMP"])]
    private ?DateTime $deliveredAt;

    #[ORM\Column(type: 'string', length: 180)]
    private string $name;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $email;

    #[ORM\Column(type: 'bigint')]
    private string $phone;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message;

    #[ORM\Column(type: 'string', length: 512)]
    private string $referer;

    #[ORM\Column(type: 'integer')]
    private int $status;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setStatus(LeadStatusEnum::default->value);
    }

    public static function make(
        User $user,
        Flow $flow,
        string $phone,
        ?string $email = '',
        ?string $name = '',
        ?string $message = ''
    ): Lead
    {
        $lead = new self;
        $lead->flow = $flow;
        $lead->phone = PhoneFactory::phoneToInt($phone);
        $lead->email = $email;
        $lead->name = $name;
        $lead->message = $message;

        $lead->referer = '';

        $lead->setOwner($user);

        return $lead;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param DateTime $deliveredAt
     */
    public function setDeliveredAt(DateTime $deliveredAt): void
    {
        $this->deliveredAt = $deliveredAt;
    }

    /**
     * @return DateTime
     */
    public function getDeliveredAt(): ?DateTime
    {
        return $this->deliveredAt;
    }

    /**
     * @param FlowSubscription $flowSubscription
     */
    public function setFlowSubscription(FlowSubscription $flowSubscription): void
    {
        $this->flowSubscription = $flowSubscription;
    }

    /**
     * @return FlowSubscription
     */
    public function getFlowSubscription(): FlowSubscription
    {
        return $this->flowSubscription;
    }

    /**
     * @param User $owner
     */
    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $buyer
     */
    public function setBuyer(User $buyer): void
    {
        $this->buyer = $buyer;
    }

    /**
     * @return User
     */
    public function getBuyer(): ?User
    {
        return $this->buyer;
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
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    public function getStatusLabel(): string
    {
        return LeadStatusEnum::get($this->status)->getLabel();
    }
}