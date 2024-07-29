<?php

namespace App\Services;

use App\Entities\Command;
use App\Entities\Forms\CommandCreateForm;
use App\Entities\Forms\CommandUpdateForm;
use App\Repositories\CommandRepository;

class CommandService
{
    public function __construct(
        private readonly CommandRepository $commandRepository
    )
    {
    }

    /**
     * @param CommandCreateForm $form
     * @return Command
     */
    public function create(CommandCreateForm $form): Command
    {
        $command = Command::makeFromForm($form);
        $this->commandRepository->save($command);

        return $command;
    }

    public function update(CommandUpdateForm $form): void
    {
        $user = $this->commandRepository->getById($form->id);

        foreach ($form->changedAttributes as $changedAttribute) {
            $user->$changedAttribute = $form->$changedAttribute;
        }

        $this->commandRepository->save($user);
    }
}