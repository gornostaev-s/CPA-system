<?php

namespace App\Entities;

class RealtorPropertyObject
{
    public $id;
    public $amoId;
    public $price;
    public $unit;
    public $name;
    public $description;
    public $roomsCount;
    public $type;
    public $city;
    public $region;
    public $toSea;
    public $area;
    public $code;
    public $images;
    public $houseType;
    public $repairs;
    public $rights;
    public $dealType;

    public $manager;

    public $floor;
    public $floors;

    public $prian;
    public $avito;
    public $site;

    public static function make(array $data)
    {
        $object = new self;

        foreach ($data['params'] as $param) {
            switch ($param['param_alias']) {
                case 'rooms_count' :
                    $object->roomsCount = $param['values'][0]['value'];
                    break;
                case 'floor' :
                    $object->floor = $param['values'][0]['value'];
                    break;
                case 'floors_count' :
                    $object->floors = $param['values'][0]['value'];
                    break;
                case 'total_square' :
                    $object->area = $param['values'][0]['value'];
                    break;
                case 'city_with_type' :
                    $object->city = $param['values'][0]['value'];
                    break;
                case 'city_district_with_type' :
                    $object->region = $param['values'][0]['value'];
                    break;
                case 'tip_dom' :
                    $object->houseType = $param['values'][0]['value'];
                    break;
                case 'repairs' :
                    $object->repairs = $param['values'][0]['value'];
                    break;
                case 'pravo' :
                    $object->rights = $param['values'][0]['value'];
                    break;
            }
        }

        $object->name = $data['name'];
        $object->amoId = $data['id'];
        $object->price = $data['price'];
        $object->unit = 'EUR';
        $object->description = $data['description_public'] ?? 'Описание отсутствует';
        $object->type = 'Новостройка'; // вторичка или новостройка
        $object->toSea = ''; // Площадь к морю
        $object->code = 'undefined';
        $object->prian = $data['export_website'];
        $object->avito = $data['export_website'];
        $object->site = $data['export_website'];

        $object->manager = $data['responsible']['name'];

        switch ($data['deal_type']['id']) {
            case 1 :
                $object->dealType = 'Сдам';
                break;
            case 2 :
                $object->dealType = 'Продам';
                break;
        }

        $images = [];

        if (!empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $images[] = $file['src'];
            }
        }

        $object->images = $images;

        return $object;
    }
}