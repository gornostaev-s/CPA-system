<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Forms\ZvonokLeadForm;
use App\Entities\ZvonokClient;
use App\Repositories\ZvonokClientRepository;
use App\Services\ZvonokService;
use App\Utils\ValidationUtil;
use ReflectionException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ZvonokController extends Controller
{
    public function __construct(
        private readonly ZvonokService $zvonokService,
        private readonly ZvonokClientRepository $zvonokClientRepository
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
        $request = ValidationUtil::validate($_GET,[
            "phone" => 'max:255',
            "projectId" => 'integer|default:102862',
        ]);

        $this->zvonokClientRepository->save(ZvonokClient::make(
            $request['phone'],
            (int)$request['projectId']
        ));

        $form = ZvonokLeadForm::makeFromRequest($request);
        $form->setProjectId($request['projectId']);
        $this->zvonokService->addLead($form);
    }

    /**
     * @return bool|string
     * @throws ReflectionException
     */
    public function index(): bool|string
    {
        return $this->view('skorozvon/index', [
            'clients' => $this->zvonokClientRepository->getAllClients(),
        ]);
    }
}