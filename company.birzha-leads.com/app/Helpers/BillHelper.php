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
}