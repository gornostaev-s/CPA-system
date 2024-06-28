<?php

namespace App\Services;

use App\Entities\Bill;
use App\Entities\Client;
use App\Entities\Company;
use App\Entities\Enums\BillType;
use App\Entities\Forms\ClientCreateForm;
use App\Entities\Forms\ClientUpdateForm;
use App\Helpers\AuthHelper;
use App\Repositories\BillRepository;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;
use App\Utils\Exceptions\ValidationException;
use Exception;
use ReflectionException;

class ClientsService
{
    public function __construct(
        private readonly ClientsRepository $clientsRepository,
        private readonly BillRepository $billRepository
    )
    {
    }

    /**
     * @param ClientCreateForm $form
     * @return Client
     */
    public function add(ClientCreateForm $form): Client
    {
        $c = Client::makeFromForm($form);
        $this->store($c);

        return $c;
    }

    /**
     * @param int $id
     * @return void
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function delete(int $id): void
    {
        if (!AuthHelper::getAuthUser()->isAdmin()) {
            throw new ValidationException("Вы не можете удалить клиента");
        }
        $company = $this->clientsRepository->getById($id);
        if (empty($company)) {
            throw new ValidationException("Клиента с ID:$id не существует");
        }
        $this->clientsRepository->delete($id);
    }

    public function store(Client $company): int
    {
        return $this->clientsRepository->save($company);
    }

    /**
     * @param ClientUpdateForm $clientUpdateForm
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function updateFromClientUpdateForm(ClientUpdateForm $clientUpdateForm): void
    {
        $client = $this->clientsRepository->getById($clientUpdateForm->id);

        foreach ($clientUpdateForm->changedAttributes as $changedAttribute) {
            if (is_array($clientUpdateForm->$changedAttribute)) {
                continue;
            }

            $client->$changedAttribute = $clientUpdateForm->$changedAttribute;
        }

        $this->updateRelatedData($clientUpdateForm);

        $this->clientsRepository->save($client);
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