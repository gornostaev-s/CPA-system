<?php

namespace App\Service;

use App\Entity\BalanceHistory;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\BalanceHistoryTypeEnum;
use App\Repository\BalanceHistoryRepository;

class BalanceHistoryService
{
    public function __construct(
        private readonly BalanceHistoryRepository $balanceHistoryRepository
    )
    {
    }

    public function store(BalanceHistory $balanceHistory): void
    {
        $this->balanceHistoryRepository->store($balanceHistory);
    }

    /**
     * @param User $user
     * @param float $amount
     * @param Order|null $order
     * @return void
     */
    public function upBalance(User $user, float $amount, ?Order $order = null): void
    {
        $balanceHistory = BalanceHistory::make($amount, BalanceHistoryTypeEnum::upBalance, $user);

        if (!empty($order)) {
            $balanceHistory->setOrder($order);
        }

        $this->balanceHistoryRepository->store($balanceHistory);
    }

    /**
     * @param User $user
     * @param float $amount
     * @param Order|null $order
     * @return void
     */
    public function downBalance(User $user, float $amount, ?Order $order = null): void
    {
        $balanceHistory = BalanceHistory::make($amount, BalanceHistoryTypeEnum::downBalance, $user);

        if (!empty($order)) {
            $balanceHistory->setOrder($order);
        }

        $this->balanceHistoryRepository->store($balanceHistory);
    }
}