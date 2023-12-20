<?php

namespace App\Services;

use App\Entities\Company;
use App\Repositories\CompanyRepository;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    )
    {
    }

    public function store(Company $company): void
    {
        $this->companyRepository->save($company);
    }
}