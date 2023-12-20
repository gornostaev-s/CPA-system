<?php

namespace App\Services;

use App\Clients\AmoRieltor;
use App\Entities\RealtorPropertyObject;

class ExportService
{
    public $service;
    public $tildaService;

    public function __construct(AmoRieltor $service, TildaService $tildaService)
    {
        $this->service = $service;
        $this->tildaService = $tildaService;
    }

    public function getObject()
    {
//        https://api.amorealtor.ru/objects/{id}
    }

    /**
     * @return array
     */
    public function getCatalogItems(): array
    {
        $objects = $this->service->getObjects();
        $collection = [];

        foreach ($objects['items'] as $object) {
            $collection[] = RealtorPropertyObject::make($object);
        }

        return $collection;
    }

    public function processTilda(string $import, string $offers, array $items)
    {
        $this->tildaService
            ->setImport($import)
            ->setOffers($offers)
            ->importImages($items)
        ;
//            ->files()
//            ->import();
    }
}