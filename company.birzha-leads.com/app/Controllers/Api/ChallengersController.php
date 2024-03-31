<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Entities\Forms\ChallengerCreateForm;
use App\Entities\Forms\ChallengerUpdateForm;
use App\Helpers\ApiHelper;
use App\Services\ChallengerService;
use App\Utils\Exceptions\ValidationException;
use App\Utils\ValidationUtil;
use ReflectionException;

class ChallengersController extends Controller
{
    public function __construct(
        private readonly ChallengerService $challengerService
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function update(): void
    {
        $request = ValidationUtil::validate($_POST,[
            "id" => 'required|integer',
            "inn" => 'max:255',
            "fio" => 'max:255',
            "phone" => 'max:255',
            "address" => 'max:255',
            "comment" => 'max:255',
            "comment_adm" => 'max:255',
            "status" => 'integer|max:255',
            "operation_type" => 'integer|max:255',
        ]);

        $this->challengerService->update(ChallengerUpdateForm::makeFromRequest($request));
    }

    /**
     * @return bool|string
     * @throws ValidationException
     */
    public function add(): bool|string
    {
        $request = ValidationUtil::validate($_POST,[
            "inn" => 'max:255',
            "fio" => 'max:255',
            "phone" => 'max:255',
            "address" => 'max:255',
            "operation_type" => 'integer|max:255',
            "owner_id" => 'integer',
        ]);

        $challenger = $this->challengerService->create(ChallengerCreateForm::makeFromRequest($request));

        return ApiHelper::sendSuccess(['inn' => $challenger->inn]);
    }
}