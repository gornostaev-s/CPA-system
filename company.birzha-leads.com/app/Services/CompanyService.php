<?php

namespace App\Services;

use App\Entities\Bill;
use App\Entities\Company;
use App\Entities\Enums\BillType;
use App\Entities\Forms\ClientCreateForm;
use App\Entities\Forms\ClientUpdateForm;
use App\Repositories\BillRepository;
use App\Repositories\CompanyRepository;
use Exception;
use ReflectionException;

class CompanyService
{
    public function __construct(
        private readonly CompanyRepository $companyRepository,
        private readonly BillRepository $billRepository
    )
    {
    }

    /**
     * @param ClientCreateForm $form
     * @return Company
     */
    public function add(ClientCreateForm $form): Company
    {
        $c = Company::makeFromForm($form);
        $this->store($c);

        return $c;
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
            if (is_array($clientUpdateForm->$changedAttribute)) {
                continue;
            }

            $client->$changedAttribute = $clientUpdateForm->$changedAttribute;
        }

        $this->updateRelatedData($clientUpdateForm);

        $this->companyRepository->save($client);
    }

    public function updateRelatedData(ClientUpdateForm $clientUpdateForm)
    {
        foreach ($clientUpdateForm->changedAttributes as $changedAttribute) {
            if (in_array($changedAttribute, ClientUpdateForm::RELATED_FIELDS)) {
                foreach (BillType::cases() as $case) {
                    if ($case->name == $changedAttribute) {
                        $type = $case->value;
                    }
                }

                if (empty($type)) {
                    continue;
                }

                $bill = $this->getClientBill($type, $clientUpdateForm->id);

                foreach ($clientUpdateForm->$changedAttribute as $key => $item) {
                    $bill->$key = $item;
                }

                $this->billRepository->save($bill);
            }
        }
    }

    public function getClientBill(int $type, int $clientId): Bill
    {
        $bill = $this->billRepository->getByTypeAndClientId($type, $clientId);

        if (empty($bill)) {
            $bill = Bill::make($type, $clientId);
        }

        return $bill;
    }
}