<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AuthHelper;
use App\RBAC\Enums\PermissionsEnum;
use App\RBAC\Managers\PermissionManager;
use App\Repositories\ChallengerRepository;
use App\Repositories\UserRepository;
use App\Utils\ValidationUtil;

class FunnelController extends Controller
{
    public function __construct(
        private readonly ChallengerRepository $challengerRepository,
        private readonly UserRepository $userRepository,
        private readonly PermissionManager $permissionManager
    )
    {
        parent::__construct();
    }

    public function index()
    {
        $user = AuthHelper::getAuthUser();
        $isAdmin = $this->permissionManager->has(PermissionsEnum::editFunnels->value);
        $employers = [];

        if ($isAdmin) {
            $request = ValidationUtil::validate($_GET,[
                "ownerId" => 'integer|max:255',
            ]);

            $employers = $this->userRepository->getEmployers();
            $ownerId = $request['ownerId'];
            if (empty($ownerId)) {
                $challengers = $this->challengerRepository->getReadyToMoveChallengers();
            } else {
                $challengers = $this->challengerRepository->getChallengersByOwnerId($ownerId);
            }
        } else {
            $challengers = $this->challengerRepository->getChallengersByOwnerId($user->id);
            $ownerId = $user->id;
        }

        return $this->view('funnel/index', [
            'challengers' => $challengers,
            'employers' => $employers ?? [],
            'ownerId' => $ownerId
        ]);
    }
}