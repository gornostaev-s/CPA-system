<?php

namespace App\Services;

use App\Entities\Challenger;
use App\Entities\Forms\ChallengerCreateForm;
use App\Repositories\ChallengerRepository;

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

    public function update()
    {

    }

    public function get()
    {

    }

    public function delete()
    {

    }
}