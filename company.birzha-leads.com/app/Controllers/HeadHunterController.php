<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\HeadHunterService;

class HeadHunterController extends Controller
{
    public function __construct(
        private readonly HeadHunterService $headHunterService
    )
    {
        parent::__construct();
    }

    public function callback()
    {
        $phpInput = file_get_contents('php://input');
        $this->headHunterService->apply(json_decode($phpInput, true));
    }
}