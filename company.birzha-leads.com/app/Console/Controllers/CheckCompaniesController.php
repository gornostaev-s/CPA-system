<?php

namespace App\Console\Controllers;

use App\Core\Controller;
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

        $token = "2a96dd4e4f30950cd6df210913e39bb7fe631e6d";
        $dadata = new DadataClient($token, null);
        $result = $dadata->findById("party", "7707083893", 1);
        $companies = $this->companyRepository->getNewCompanies();

        foreach ($companies as $company) {

        }
    }
}