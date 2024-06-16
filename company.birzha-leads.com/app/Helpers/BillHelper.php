<?php

namespace App\Helpers;

use App\Repositories\BillRepository;

class BillHelper
{
    public function __construct(
        private readonly BillRepository $billRepository
    )
    {
    }

    public function getOpenBillsCountByUserId(int $userId)
    {
        return $this->billRepository->getOpenBillsCountByUserId($userId);
    }

    public function getBillsCountByUserId(int $userId, int $type = null)
    {
        return $this->billRepository->getBillsCountByUserId($userId, $type);
    }
}