<?php

namespace App\Entities;

use AmoCRM\Models\CatalogElementModel;

class PropertyObject
{
    public $id;
    public $amoId;
    public $price;
    public $unit;
    public $description;
    public $roomsCount;
    public $type;
    public $city;
    public $region;
    public $toSea;
    public $area;
    public $code;

    public $floor;
    public $floors;

    public $prian;
    public $avito;
    public $site;
    public $manager;

    public static function make(CatalogElementModel $model): PropertyObject
    {
        $fields = $model->getCustomFieldsValues();

        $object = new self;

        if (empty($fields)) {
            return $object;
        }

        $object->amoId = $model->getId();
        $object->price = self::getFieldById($fields, 839529);
        $object->unit = self::getFieldById($fields, 839537);
        $object->description = self::getFieldById($fields, 839527);
        $object->roomsCount = self::getFieldById($fields, 848305);
        $object->type = self::getFieldById($fields, 848307);
        $object->city = self::getFieldById($fields, 848309);
        $object->region = self::getFieldById($fields, 848311);
        $object->toSea = self::getFieldById($fields, 848313);
        $object->area = self::getFieldById($fields, 848315);
        $object->code = self::getFieldById($fields, 848317);
        $object->floor = self::getFieldById($fields, 848437);
        $object->floors = self::getFieldById($fields, 848439);
        $object->prian = (bool)self::getFieldById($fields, 848357);
        $object->avito = (bool)self::getFieldById($fields, 848359);
        $object->site = (bool)self::getFieldById($fields, 848361);

        return $object;
    }

    private static function getFieldById($fields, int $id)
    {
        return !empty($fields->getBy('fieldId', $id))
            ? $fields->getBy('fieldId', $id)->getValues()[0]->getValue()
            : null;
    }
}