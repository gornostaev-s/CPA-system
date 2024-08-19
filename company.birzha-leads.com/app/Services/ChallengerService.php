<?php

namespace App\Services;

use App\Entities\Challenger;
use App\Entities\Client;
use App\Entities\Company;
use App\Entities\Enums\ProcessStatus;
use App\Entities\Forms\ChallengerCreateForm;
use App\Entities\Forms\ChallengerUpdateForm;
use App\Helpers\AuthHelper;
use App\Repositories\ChallengerRepository;
use App\Repositories\ClientsRepository;
use App\Repositories\CompanyRepository;
use App\Utils\Exceptions\ValidationException;
use Exception;
use ReflectionException;

class ChallengerService
{
    public function __construct(
        private readonly ChallengerRepository $challengerRepository,
        private readonly ClientsRepository $clientsRepository,
    )
    {
    }

    /**
     * @param ChallengerCreateForm $form
     * @return Challenger
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function create(ChallengerCreateForm $form): Challenger
    {
        $matchClient = $this->clientsRepository->findOneByInn($form->inn);

        if ($matchClient) {
            throw new ValidationException("Данный ИНН есть в системе обратитесь к Администратору");
        }

        $challenger = Challenger::makeFromForm($form);
        $this->challengerRepository->save($challenger);

        return $challenger;
    }

    /**
     * @param ChallengerUpdateForm $form
     * @return void
     * @throws ReflectionException
     */
    public function update(ChallengerUpdateForm $form): void
    {
        $challenger = $this->challengerRepository->getById($form->id);

        foreach ($form->changedAttributes as $changedAttribute) {
            if (is_array($form->$changedAttribute)) {
                continue;
            }

            $challenger->$changedAttribute = $form->$changedAttribute;
        }

        $this->challengerRepository->save($challenger);
    }

    /**
     * @param int $challengerId
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function move(int $challengerId): void
    {
        $challenger = $this->challengerRepository->getById($challengerId);

        if (empty($challenger)) {
            throw new ValidationException('Клиент в воронке не найден!');
        }

        $matchClient = $this->clientsRepository->findOneByInn($challenger->inn);

        if ($matchClient) {
            throw new ValidationException("Данный ИНН есть в системе обратитесь к Администратору");
        }

        $this->clientsRepository->save(Client::makeByChallenger($challenger));
        $challenger->process_status = ProcessStatus::moved->value;
        $this->challengerRepository->save($challenger);
    }

    public function delete(int $id)
    {
        $company = $this->challengerRepository->getById($id);
        if (empty($company)) {
            throw new ValidationException("Клиента с ID:$id не существует");
        }
        if (!($company->owner_id == AuthHelper::getAuthUser()->id || AuthHelper::getAuthUser()->isAdmin())) {
            throw new ValidationException("Вы не можете удалить клиента");
        }
        $this->challengerRepository->delete($id);
    }
}