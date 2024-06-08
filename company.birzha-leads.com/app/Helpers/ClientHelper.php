<?php

namespace App\Helpers;

use App\Repositories\CompanyRepository;

class ClientHelper
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function getClientsCountByUserId(int $userId)
    {
        return $this->companyRepository->getClientsCountByUserId($userId);
    }
}