<?php

namespace App\Console\Controllers;

use App\Core\Controller;
use App\Entities\Company;
use App\Repositories\CompanyRepository;
use Dadata\DadataClient;
use ReflectionException;

class CheckCompaniesController extends Controller
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    public function index(): void
    {
        // https://github.com/hflabs/dadata-php

        $dadata = new DadataClient(DADATA_TOKEN, null);
        $companies = $this->companyRepository->getNewCompanies();

        foreach ($companies as $company) {
            $result = $dadata->findById("party", $company->inn, 1);

            if (!empty($result)) {
                $company->setStatus(Company::STATUS_REGISTERED);
                $this->companyRepository->save($company);
            }
        }
    }
}