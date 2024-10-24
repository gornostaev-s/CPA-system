<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Entities\DateTimePeriod;
use App\Helpers\AuthHelper;
use App\Helpers\BillHelper;
use App\Helpers\ClientHelper;
use App\Helpers\DateTimeInputHelper;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;
use App\Repositories\UserRepository;
use App\Utils\ValidationUtil;
use DateTimeImmutable;
use ReflectionException;

class StatController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly BillHelper $billHelper,
        private readonly ClientHelper $clientHelper,
        private readonly PermissionManager $permissionManager
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
        $request = ValidationUtil::validate($_GET, [
            "datetime" => 'max:255',
        ]);

        $period = null;
        if (!empty($request['datetime'])) {
            $periodArray = DateTimeInputHelper::getIntervalFromString($request['datetime'], 'Y-m-d');
            $period = DateTimePeriod::make(new DateTimeImmutable($periodArray['startDate']), new DateTimeImmutable($periodArray['endDate']));
        }

        $user = AuthHelper::getAuthUser();
        $isAdmin = $this->permissionManager->has(PermissionsEnum::allStat->value);

        return $this->view('stat/index', [
            'employers' => !$isAdmin ? [$this->userRepository->getUserById($user->id)] : $this->userRepository->getNotDismissedEmployers(),
            'billHelper' => $this->billHelper,
            'clientHelper' => $this->clientHelper,
            'period' => $period,
            'dayPeriod' => DateTimePeriod::make(
                (new DateTimeImmutable()),
                (new DateTimeImmutable())
            ),
            'weekPeriod' => DateTimePeriod::make(
                (new DateTimeImmutable())->modify('monday this week'),
                (new DateTimeImmutable())
            )
        ]);
    }
}