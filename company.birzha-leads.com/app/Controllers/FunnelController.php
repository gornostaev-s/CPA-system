<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\AuthHelper;
use App\Repositories\ChallengerRepository;
use App\Repositories\UserRepository;
use App\Utils\ValidationUtil;

class FunnelController extends Controller
{
    public function __construct(
        private readonly ChallengerRepository $challengerRepository,
        private readonly UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    public function index()
    {
        $user = AuthHelper::getAuthUser();
        $isAdmin = $user?->isAdmin();
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
                $challengers = $this->challengerRepository->getChallengersByOwnerId($user->id);
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