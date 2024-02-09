<?php

namespace App\Services;

use App\Entities\Company;
use App\Entities\Forms\ClientUpdateForm;
use App\Repositories\CompanyRepository;
use Exception;
use ReflectionException;

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

    /**
     * @param ClientUpdateForm $clientUpdateForm
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function updateFromClientUpdateForm(ClientUpdateForm $clientUpdateForm): void
    {
        $client = $this->companyRepository->getById($clientUpdateForm->id);

        foreach ($clientUpdateForm->changedAttributes as $changedAttribute) {
            $client->$changedAttribute = $clientUpdateForm->$changedAttribute;
        }

        $this->companyRepository->save($client);
    }
}