<?php

namespace App\Helpers;

use App\Entities\DateTimePeriod;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;

class ClientHelper
{
    public function __construct(
        private readonly ClientsRepository $clientsRepository
    )
    {
    }

    public function getClientsCountByUserId(int $userId)
    {
        return $this->clientsRepository->getClientsCountByUserId($userId);
    }

    public function getOperationTypeCountByUserId(int $userId, int $operationType)
    {
        return $this->clientsRepository->getOperationTypeCountByUserId($userId, $operationType);
    }

    public function getOperationTypeCountByUserIdAndPeriod(int $userId, int $operationType, DateTimePeriod $period)
    {
        return $this->clientsRepository->getOperationTypeCountByUserIdAndPeriod($userId, $operationType, $period);
    }
}