<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\CommandCreateForm;
use App\Entities\Forms\CommandUpdateForm;
use App\Helpers\ApiHelper;
use App\Services\CommandService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;

class CommandsController extends Controller
{
    public function __construct(
        private readonly CommandService $commandService
    )
    {
        parent::__construct();
    }

    /**
     * @return bool|string
     * @throws ValidationException
     */
    public function add(): bool|string
    {
        $request = ValidationUtil::validate($_POST,[
            "title" => 'required',
            "telegram_id" => 'required',
        ]);

        $command = $this->commandService->create(CommandCreateForm::makeFromRequest($request));

        return ApiHelper::sendSuccess(['title' => $command->title]);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function update(): void
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'required|integer',
            "title" => 'max:255',
            "telegram_id" => 'max:255',
        ]);

        $this->commandService->update(CommandUpdateForm::makeFromRequest($request));
    }
}