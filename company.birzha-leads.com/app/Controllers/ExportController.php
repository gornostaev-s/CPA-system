<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ExportService;

class ExportController extends Controller
{
    /**
     * @var ExportService
     */
    private $service;

    public function __construct(ExportService $exportService)
    {
        parent::__construct();
        $this->service = $exportService;
    }

    public function avito()
    {
        header('Content-type: text/xml');
        return $this->view('export/avito', [
            'items' => $this->service->getCatalogItems()
        ]);
    }

    public function tilda()
    {
        $items = $this->service->getCatalogItems();

        $offers = $this->view('export/tilda_offers', [
            'items' => $items
        ]);

        $import = $this->view('export/tilda_import', [
            'items' => $this->service->getCatalogItems()
        ]);

        $this->service->processTilda($import, $offers, $items);
    }

    public function prian()
    {
        return $this->view('export/prian', [
            'items' => $this->service->getCatalogItems()
        ]);
    }
}