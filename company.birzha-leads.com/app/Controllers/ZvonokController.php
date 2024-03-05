<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Forms\ZvonokLeadForm;
use App\Services\ZvonokService;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ZvonokController extends Controller
{
    public function __construct(
        private readonly ZvonokService $zvonokService
    )
    {
        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function callback()
    {
        $form = ZvonokLeadForm::makeFromRequest($_GET);
        $form->setProjectId(102862);
        $this->zvonokService->addLead($form);
    }
}