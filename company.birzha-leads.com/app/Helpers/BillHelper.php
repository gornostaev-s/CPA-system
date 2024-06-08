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

    public function getBillsCountByUserId(int $userId)
    {
        return $this->billRepository->getBillsCountByUserId($userId);
    }
}