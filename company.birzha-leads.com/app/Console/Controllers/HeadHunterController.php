<?php

namespace App\Console\Controllers;

use App\Clients\HeadHunterClient;
use App\Core\Controller;

class HeadHunterController extends Controller
{
    public function __construct(
        private readonly HeadHunterClient $headHunterClient
    )
    {
        parent::__construct();
    }

    public function import()
    {
        $responses = $this->headHunterClient->getVacancyResponses(91481233);

        echo '<pre>';
        var_dump($responses);
        die;

        // 91481233
        // 91740031
    }
}