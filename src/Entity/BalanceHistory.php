<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Enum\BalanceHistoryTypeEnum;
use App\Repository\BalanceHistoryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BalanceHistoryRepository::class)]
#[ORM\Table(name: 'balance_history')]
class BalanceHistory
{
    use IdTrait;
    use CreatedAtTrait;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, options: ['default' => 0.00])]
    private float $amount;

    #[ORM\Column]
    private int $type;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Order::class)]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id', nullable: true)]
    private Order $order;

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }

    public static function make(
        float $amount,
        BalanceHistoryTypeEnum $type,
        User $user
    ): BalanceHistory
    {
        $m = new self;
        $m->amount = $amount;
        $m->type = $type->value;
        $m->user = $user;

        return $m;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param BalanceHistoryTypeEnum $type
     */
    public function setType(BalanceHistoryTypeEnum $type): void
    {
        $this->type = $type->value;
    }

    /**
     * @return BalanceHistoryTypeEnum
     */
    public function getType(): BalanceHistoryTypeEnum
    {
        return BalanceHistoryTypeEnum::getEnumById($this->type);
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

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}