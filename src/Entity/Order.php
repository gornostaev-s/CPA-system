<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Enum\OrderStatusEnum;
use App\Enum\OrderTypeEnum;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: 'orders')]
class Order
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\Column]
    private int $type;

    #[ORM\Column]
    private int $status;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => 0.00])]
    private int $amount;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false, options: ['default' => "CURRENT_TIMESTAMP"])]
    private DateTime $updatedAt;

    #[ORM\Column(name: 'order_data', type: 'json', nullable: true)]
    private array $orderData;

    #[ORM\Column(name: 'payment_order_id', nullable: true)]
    private string $paymentOrderId;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
    }

    public static function make(
        OrderStatusEnum $status,
        OrderTypeEnum $type,
        float $amount,
        User $user
    ): Order
    {
        $m = new self;
        $m->status = $status->value;
        $m->type = $type->value;
        $m->amount = $amount;
        $m->user = $user;

        return $m;
    }

    /**
     * @return OrderTypeEnum
     */
    public function getType(): OrderTypeEnum
    {
        return OrderTypeEnum::getEnumById($this->type);
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param OrderStatusEnum $status
     */
    public function setStatus(OrderStatusEnum $status): void
    {
        $this->status = $status->value;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setOrderParam(string $param, mixed $value): void
    {
        $this->orderData[$param] = $value;
    }

    public function getOrderParam(string $param): mixed
    {
        return !empty($this->orderData[$param]) ? $this->orderData[$param] : null;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}