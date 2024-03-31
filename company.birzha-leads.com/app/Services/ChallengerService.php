<?php

namespace App\Services;

use App\Entities\Challenger;
use App\Entities\Forms\ChallengerCreateForm;
use App\Entities\Forms\ChallengerUpdateForm;
use App\Repositories\ChallengerRepository;
use ReflectionException;

class ChallengerService
{
    public function __construct(
        private readonly ChallengerRepository $challengerRepository
    )
    {
    }

    /**
     * @param ChallengerCreateForm $form
     * @return Challenger
     */
    public function create(ChallengerCreateForm $form): Challenger
    {
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

//    public function get()
//    {
//
//    }

//    public function delete()
//    {
//
//    }
}