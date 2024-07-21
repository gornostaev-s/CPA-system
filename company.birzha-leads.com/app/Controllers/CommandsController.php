<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CommandRepository;
use ReflectionException;

class CommandsController extends Controller
{
    public function __construct(
        private readonly CommandRepository $commandRepository
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     */
    public function index(): bool|string
    {
        return $this->view('commands/index', [
            'commands' => $this->commandRepository->getAllCommands()
        ]);
    }
}